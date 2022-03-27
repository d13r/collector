#!/bin/bash
set -o nounset -o pipefail -o errexit
cd "$(dirname "$0")/../.."

################################################################################
# Upload the current branch to both the staging site and to GitLab.
################################################################################

source "scripts/_includes/colors.sh"

# Configure the Git remotes
scripts/deploy/_config.sh

# Run tests, etc. (Due to 'errexit' this script will exit if tests fail)
scripts/deploy/_before-deploy.sh

# Push to GitLab
if git config remote.origin.url &>/dev/null; then
    green bold "Deploying to origin ($(git config remote.origin.url))..."
    git push origin HEAD
    echo
fi

# Push to Staging
green bold "Deploying to staging ($(git config remote.staging.url))..."
git push staging HEAD
echo
