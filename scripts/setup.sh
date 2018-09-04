#!/bin/bash
set -o nounset -o pipefail -o errexit
cd "$(dirname "$0")/.."

################################################################################
# Install dependencies
################################################################################

source scripts/_colors.sh

# Get mode
mode="${1:-}"

# Check parameters & show usage info
if [ "$mode" != "prod" ] && [ "$mode" != "dev" ]; then
    echo "Usage: t setup prod - Install in production mode"
    echo "       t setup dev  - Install in development mode"

    if [ $# -eq 0 ]; then
        exit 0
    else
        exit 1
    fi
fi

# Header
header() {
    echo
    blue bold '================================================================================'
    blue bold " $1"
    blue bold '================================================================================'
    echo
}

# Create files
create_file() {
    dest="$1"
    src="${2:-$1.example}"

    if [ ! -f "$dest" ]; then
        echo "Copying '$src' to '$dest'"
        cp $src $dest
    else
        echo "'$dest' already exists"
    fi
}

#header "Creating files"
#create_file .env
#create_file www/.htaccess

# Composer
if [ -f composer.json ]; then
    header 'PHP - Composer (composer.json)'

    if [ "$mode" = "dev" ]; then
        composer install
    else
        composer install --no-dev
    fi
fi

# Yarn
if [ -f package.json ]; then
    header 'Node.js - Yarn (package.json)'

    if [ "$mode" = "dev" ]; then
        yarn install
    else
        yarn install --prod
    fi
fi
