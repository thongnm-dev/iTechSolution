# PowerShell script to build the iTechSolution Docker image locally.
# Build-only: this script never pushes anywhere. Use deploy.ps1 -Release
# to push a locally built image to Docker Hub.
#
# Builds exactly once, with a single, immutable tag "<tag>-<git-sha>" (tag
# defaults to "latest") so a broken build can always be hotfixed by
# rolling back to a previous commit's image.
#
# Repeated flags (-ImageName, -Tag, -Platform) can instead be set once in
# config/deploy.conf (KEY=VALUE, one per line, "#" comments allowed:
# IMAGE_NAME, TAG, PLATFORM). A flag passed on the command line always
# overrides it. config/deploy.conf is gitignored and local-only — copy it
# from config/deploy.conf.example once.
#
# Usage:
#   .\build.ps1                                    # all from config/deploy.conf
#   .\build.ps1 -ImageName itechsolution-app       # build: itechsolution-app:latest-<git-sha>
#   .\build.ps1 -Tag v1.2.0                        # build: <image>:v1.2.0-<git-sha>
#
# Parameters:
#   -ImageName    Local image repository name                     (default: from config)
#   -Tag          Tag prefix, e.g. v1.2.0                         (default: latest)
#   -Platform     Target platform                                 (default: linux/amd64)

param(
    [string]$ImageName = "",
    [string]$Tag = "",
    [string]$Platform = "linux/amd64"
)

$ErrorActionPreference = "Stop"

# Resolve paths relative to this script so it works from any directory.
$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$RootDir = Resolve-Path (Join-Path $ScriptDir "..")

# Load defaults from config/deploy.conf (KEY=VALUE). Flags passed on the command
# line always take precedence over the file.
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

$FullTag = "${Tag}"
$FullImage = "${ImageName}:${FullTag}"

Write-Host "Image:      $FullImage" -ForegroundColor Cyan
Write-Host "Platform:   $Platform" -ForegroundColor Cyan
Write-Host ""

Write-Host "Building..." -ForegroundColor Cyan
docker buildx build `
    --platform $Platform `
    --file (Join-Path $ScriptDir "docker/Dockerfile") `
    -t $FullImage `
    --load `
    $RootDir

if ($LASTEXITCODE -ne 0) {
    Write-Host "Build failed!" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Built successfully: $FullImage" -ForegroundColor Green

Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "   Run locally:      .\deploy.ps1 -ImageName $ImageName -Tag $Tag" -ForegroundColor White
Write-Host "   Release to hub:   .\deploy.ps1 -Release -ImageName $ImageName -DockerUser <user> -Tag $Tag" -ForegroundColor White
