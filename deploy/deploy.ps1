# PowerShell deployment script for iTechSolution.
#
# Two modes, sharing the image built by build.ps1 (single tag "<tag>-<git-sha>"):
#   Local      (default) - runs the image locally via docker-compose.
#   Release    (-Release) - tags the locally built image and pushes it to Docker Hub.
#
# Repeated flags (-ImageName, -Tag, -Platform, -DockerUser) can instead be set
# once in config/deploy.conf (KEY=VALUE, one per line, "#" comments allowed:
# IMAGE_NAME, TAG, PLATFORM, DOCKER_USER). A flag passed on the command line
# always overrides it. -Release and -Rebuild are never read from
# config/deploy.conf — they must always be passed explicitly on the command
# line. config/deploy.conf is gitignored and local-only — copy it from
# config/deploy.conf.example once.
#
# Usage:
#   .\deploy.ps1                                                          # run locally (from config)
#   .\deploy.ps1 -ImageName itechsolution-app                             # run locally
#   .\deploy.ps1 -Release -DockerUser me                                  # push image to Docker Hub
#   .\deploy.ps1 -Release -DockerUser me -Tag v1.2.0                      # push with custom tag
#   .\deploy.ps1 -Rebuild                                                 # rebuild then run locally
#
# Parameters:
#   -ImageName    Local image repository name, must match build.ps1              (default: from config)
#   -Release      Push to Docker Hub instead of running locally
#   -DockerUser   Docker Hub username / org (required with -Release)
#   -Tag          Tag prefix, must match what build.ps1 used                     (default: latest)
#   -Rebuild      Build fresh via build.ps1 first, so the image pushed/run is always a new build
#   -Platform     Target platform, forwarded to build.ps1 when -Rebuild is set   (default: linux/amd64)
#
# Requires an image already built with build.ps1 (same -ImageName/-Tag,
# and the same git commit so the "<tag>-<git-sha>" suffix matches), unless
# -Rebuild is passed to build it here first.

param(
    [switch]$Release,
    [string]$DockerUser = "",
    [string]$ImageName = "",
    [string]$Tag = "",
    [switch]$Rebuild,
    [string]$Platform = "linux/amd64"
)

$ErrorActionPreference = "Stop"

$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$RootDir = Resolve-Path (Join-Path $ScriptDir "..")

# Load defaults from config/deploy.conf (KEY=VALUE). Flags passed on the command
# line always take precedence over the file. -Release/-Rebuild are excluded
# on purpose so a config file can never silently trigger a push or rebuild.
$ConfigFile = Join-Path $ScriptDir "config/deploy.conf"
$Config = @{}
if (Test-Path $ConfigFile) {
    Get-Content $ConfigFile | ForEach-Object {
        $line = $_.Trim()
        if ($line -eq "" -or $line.StartsWith("#")) { return }
        $idx = $line.IndexOf("=")
        if ($idx -gt 0) {
            $key = $line.Substring(0, $idx).Trim()
            $value = $line.Substring($idx + 1).Trim().Trim('"').Trim("'")
            $Config[$key] = $value
        }
    }
}

if (-not $PSBoundParameters.ContainsKey('ImageName') -and $Config.ContainsKey('IMAGE_NAME')) { $ImageName = $Config['IMAGE_NAME'] }
if (-not $PSBoundParameters.ContainsKey('Tag') -and $Config.ContainsKey('TAG')) { $Tag = $Config['TAG'] }
if (-not $PSBoundParameters.ContainsKey('Platform') -and $Config.ContainsKey('PLATFORM')) { $Platform = $Config['PLATFORM'] }
if (-not $PSBoundParameters.ContainsKey('DockerUser') -and $Config.ContainsKey('DOCKER_USER')) { $DockerUser = $Config['DOCKER_USER'] }

if ($ImageName -eq "") {
    Write-Host "-ImageName is required (pass -ImageName or set IMAGE_NAME in config/deploy.conf)." -ForegroundColor Red
    exit 1
}

if ($Tag -eq "") { $Tag = "latest" }

try {
    $GitSha = (git -C $RootDir rev-parse --short HEAD).Trim()
} catch {
    $GitSha = "unknown"
}

$FullTag = "${Tag}-${GitSha}"
$LocalImage = "${ImageName}:${FullTag}"

function Test-LocalImage {
    param([string]$ImageRef)
    docker image inspect $ImageRef *> $null
    return $LASTEXITCODE -eq 0
}

if ($Rebuild) {
    & (Join-Path $ScriptDir "build.ps1") -ImageName $ImageName -Tag $Tag -Platform $Platform
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Rebuild failed!" -ForegroundColor Red
        exit 1
    }
}

if (-not (Test-LocalImage $LocalImage)) {
    Write-Host "Local image not found: $LocalImage" -ForegroundColor Red
    Write-Host "   Run '.\build.ps1 -ImageName $ImageName -Tag $Tag' first." -ForegroundColor Yellow
    exit 1
}

if ($Release) {
    if ($DockerUser -eq "") {
        Write-Host "-DockerUser is required with -Release." -ForegroundColor Red
        exit 1
    }

    $RemoteImage = "${DockerUser}/${ImageName}:${FullTag}"

    Write-Host "Pushing to Docker Hub as $RemoteImage ..." -ForegroundColor Cyan

    docker tag $LocalImage $RemoteImage
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Failed to tag $LocalImage as $RemoteImage" -ForegroundColor Red
        exit 1
    }

    docker push $RemoteImage
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Push failed for $RemoteImage" -ForegroundColor Red
        exit 1
    }

    Write-Host ""
    Write-Host "Pushed successfully: $RemoteImage" -ForegroundColor Green
    exit 0
}

# --- Local deployment ---

Write-Host "Starting deployment process..." -ForegroundColor Green

$ComposeFile = "docker-compose.yml"

if (!(Test-Path (Join-Path $ScriptDir ".env"))) {
    Write-Host "Creating .env file from template..." -ForegroundColor Yellow
    Copy-Item (Join-Path $ScriptDir ".env.example") (Join-Path $ScriptDir ".env")
    Write-Host "Please edit deploy/.env with your values before running again!" -ForegroundColor Yellow
    exit 0
}

Write-Host "Starting services with $LocalImage ($ComposeFile)..." -ForegroundColor Cyan
docker-compose --project-directory $ScriptDir -f (Join-Path $ScriptDir "docker/$ComposeFile") up -d

if ($LASTEXITCODE -ne 0) {
    Write-Host "Failed to start services!" -ForegroundColor Red
    exit 1
}

# Wait for services to be ready
Write-Host "Waiting for services to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 15

# Check health
$AppPort = if ($env:APP_PORT) { $env:APP_PORT } else { "80" }
Write-Host "Checking app health..." -ForegroundColor Cyan
try {
    $response = Invoke-WebRequest -Uri "http://localhost:$AppPort" -UseBasicParsing
    if ($response.StatusCode -eq 200) {
        Write-Host "App is healthy!" -ForegroundColor Green
    }
} catch {
    Write-Host "App health check failed!" -ForegroundColor Red
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

Write-Host "Deployment completed successfully!" -ForegroundColor Green
Write-Host "App is running on: http://localhost:$AppPort" -ForegroundColor Cyan
Write-Host "Admin panel: http://localhost:$AppPort/admin" -ForegroundColor Cyan

Write-Host ""
Write-Host "Useful commands:" -ForegroundColor Yellow
$ComposeArgs = "--project-directory `"$ScriptDir`" -f `"$(Join-Path $ScriptDir "docker/$ComposeFile")`""
Write-Host "  - View logs: docker-compose $ComposeArgs logs -f" -ForegroundColor White
Write-Host "  - Stop services: docker-compose $ComposeArgs down" -ForegroundColor White
Write-Host "  - Restart app: docker-compose $ComposeArgs restart app" -ForegroundColor White
