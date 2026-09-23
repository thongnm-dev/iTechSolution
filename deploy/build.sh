#!/bin/bash

# Build the iTechSolution Docker image locally.
# Build-only: this script never pushes anywhere. Use deploy.sh --release
# to push a locally built image to Docker Hub.
#
# Builds exactly once, with a single, immutable tag "<tag>-<git-sha>" (tag
# defaults to "latest") so a broken build can always be hotfixed by
# rolling back to a previous commit's image.
#
# Repeated flags (-n, -t, -p) can instead be set once in
# config/deploy.conf (KEY=VALUE, one per line, "#" comments allowed:
# IMAGE_NAME, TAG, PLATFORM). A flag passed on the command line always
# overrides it. config/deploy.conf is gitignored and local-only — copy it
# from config/deploy.conf.example once.
#
# Usage:
#   ./build.sh                                    # all from config/deploy.conf
#   ./build.sh -n itechsolution-app               # build: itechsolution-app:latest-<git-sha>
#   ./build.sh -n itechsolution-app -t v1.2.0     # build: itechsolution-app:v1.2.0-<git-sha>
#
# Options:
#   -n, --image-name NAME    local image repository name              (default: from config)
#   -t, --tag TAG            tag prefix, e.g. v1.2.0                  (default: latest)
#   -p, --platform PLATFORM  target platform                          (default: linux/amd64)

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

IMAGE_NAME=""
TAG=""
PLATFORM=""

# Load defaults from config/deploy.conf. Flags passed on the command line (parsed
# below) always override it.
CONFIG_FILE="$SCRIPT_DIR/config/deploy.conf"
if [ -f "$CONFIG_FILE" ]; then
    source "$CONFIG_FILE"
fi

while [ $# -gt 0 ]; do
    case "$1" in
        -n|--image-name) IMAGE_NAME="$2"; shift 2 ;;
        -t|--tag) TAG="$2"; shift 2 ;;
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
FULL_IMAGE="${IMAGE_NAME}:${FULL_TAG}"

echo "Image:      $FULL_IMAGE"
echo "Platform:   $PLATFORM"
echo ""

echo "Building..."
docker buildx build \
    --platform "$PLATFORM" \
    --file "$SCRIPT_DIR/docker/Dockerfile" \
    -t "$FULL_IMAGE" \
    --load \
    "$ROOT_DIR"

echo ""
echo "Built successfully: $FULL_IMAGE"

echo ""
echo "Next steps:"
echo "   Run locally:      ./deploy.sh -n $IMAGE_NAME -t $TAG"
echo "   Release to hub:   ./deploy.sh -n $IMAGE_NAME --release -u <user> -t $TAG"
