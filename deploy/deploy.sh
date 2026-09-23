#!/bin/bash

# Deployment script for iTechSolution.
#
# Two modes, sharing the image built by build.sh (single tag "<tag>-<git-sha>"):
#   Local   (default)   - runs the image locally via docker-compose.
#   Release (--release) - tags the locally built image and pushes it to Docker Hub.
#
# Repeated flags (-n, -t, -p, -u) can instead be set once in
# config/deploy.conf (KEY=VALUE, one per line, "#" comments allowed:
# IMAGE_NAME, TAG, PLATFORM, DOCKER_USER). A flag passed on the command line
# always overrides it. --release and --rebuild are never read from
# config/deploy.conf — they must always be passed explicitly on the command
# line. config/deploy.conf is gitignored and local-only — copy it from
# config/deploy.conf.example once.
#
# Usage:
#   ./deploy.sh                                            # run locally (from config)
#   ./deploy.sh -n itechsolution-app                       # run locally
#   ./deploy.sh --release -u me                            # push image to Docker Hub
#   ./deploy.sh --release -u me -t v1.2.0                  # push with custom tag
#   ./deploy.sh --rebuild                                  # rebuild then run locally
#
# Options:
#   -n, --image-name NAME    local image repository name, must match build.sh   (default: from config)
#   -r, --release            push to Docker Hub instead of running locally
#   -u, --docker-user USER   Docker Hub username / org (required with --release)
#   -t, --tag TAG            tag prefix, must match what build.sh used          (default: latest)
#   -b, --rebuild            build fresh via build.sh first
#   -p, --platform PLATFORM  target platform, forwarded to build.sh when --rebuild is set (default: linux/amd64)
#
# Requires an image already built with build.sh (same -n/-t, and the same
# git commit so the "<tag>-<git-sha>" suffix matches), unless --rebuild is
# passed to build it here first.

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

RELEASE="false"
DOCKER_USER=""
IMAGE_NAME=""
TAG=""
REBUILD="false"
PLATFORM=""

# Load defaults from config/deploy.conf. Flags passed on the command line (parsed
# below) always override it. RELEASE/REBUILD are intentionally not affected
# by anything config/deploy.conf sets — only the flags below can turn them on.
CONFIG_FILE="$SCRIPT_DIR/config/deploy.conf"
if [ -f "$CONFIG_FILE" ]; then
    source "$CONFIG_FILE"
fi
RELEASE="false"
REBUILD="false"

while [ $# -gt 0 ]; do
    case "$1" in
        -r|--release) RELEASE="true"; shift ;;
        -u|--docker-user) DOCKER_USER="$2"; shift 2 ;;
        -n|--image-name) IMAGE_NAME="$2"; shift 2 ;;
        -t|--tag) TAG="$2"; shift 2 ;;
        -b|--rebuild) REBUILD="true"; shift ;;
        -p|--platform) PLATFORM="$2"; shift 2 ;;
        *)
            echo "Unknown option: $1"
            exit 1
            ;;
    esac
done

if [ -z "$PLATFORM" ]; then PLATFORM="linux/amd64"; fi

if [ -z "$IMAGE_NAME" ]; then
    echo "-n/--image-name is required (pass -n or set IMAGE_NAME in config/deploy.conf)."
    exit 1
fi

if [ -z "$TAG" ]; then
    TAG="latest"
fi

GIT_SHA="$(git -C "$ROOT_DIR" rev-parse --short HEAD 2>/dev/null || echo "unknown")"
FULL_TAG="${TAG}-${GIT_SHA}"
LOCAL_IMAGE="${IMAGE_NAME}:${FULL_TAG}"

image_exists() {
    docker image inspect "$1" > /dev/null 2>&1
}

if [ "$REBUILD" = "true" ]; then
    "$SCRIPT_DIR/build.sh" -n "$IMAGE_NAME" -t "$TAG" -p "$PLATFORM"
fi

if ! image_exists "$LOCAL_IMAGE"; then
    echo "Local image not found: $LOCAL_IMAGE"
    echo "   Run './build.sh -n $IMAGE_NAME -t $TAG' first."
    exit 1
fi

if [ "$RELEASE" = "true" ]; then
    if [ -z "$DOCKER_USER" ]; then
        echo "--docker-user is required with --release."
        exit 1
    fi

    REMOTE_IMAGE="${DOCKER_USER}/${IMAGE_NAME}:${FULL_TAG}"

    echo "Pushing to Docker Hub as $REMOTE_IMAGE ..."
    docker tag "$LOCAL_IMAGE" "$REMOTE_IMAGE"
    docker push "$REMOTE_IMAGE"

    echo ""
    echo "Pushed successfully: $REMOTE_IMAGE"
    exit 0
fi

# --- Local deployment ---

echo "Starting deployment process..."

COMPOSE_FILE="docker-compose.yml"

if [ ! -f "$SCRIPT_DIR/.env" ]; then
    echo "Creating .env file from template..."
    cp "$SCRIPT_DIR/.env.example" "$SCRIPT_DIR/.env"
    echo "Please edit deploy/.env with your values before running again!"
    exit 0
fi

echo "Starting services with $LOCAL_IMAGE ($COMPOSE_FILE)..."
docker-compose --project-directory "$SCRIPT_DIR" -f "$SCRIPT_DIR/docker/$COMPOSE_FILE" up -d

echo "Waiting for services to be ready..."
sleep 15

APP_PORT="${APP_PORT:-80}"
echo "Checking app health..."
if curl -f "http://localhost:$APP_PORT" > /dev/null 2>&1; then
    echo "App is healthy!"
else
    echo "App health check failed!"
    exit 1
fi

echo "Deployment completed successfully!"
echo "App is running on: http://localhost:$APP_PORT"
echo "Admin panel: http://localhost:$APP_PORT/admin"

COMPOSE_ARGS="--project-directory \"$SCRIPT_DIR\" -f \"$SCRIPT_DIR/docker/$COMPOSE_FILE\""
echo ""
echo "Useful commands:"
echo "  - View logs: docker-compose $COMPOSE_ARGS logs -f"
echo "  - Stop services: docker-compose $COMPOSE_ARGS down"
echo "  - Restart app: docker-compose $COMPOSE_ARGS restart app"
