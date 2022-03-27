#!/bin/bash
set -o nounset -o pipefail -o errexit
cd "$(dirname "$0")/../.."

################################################################################
# This script is called by each of the deploy scripts.
################################################################################

set_remote() {
    git remote set-url "$1" "$2" 2>/dev/null || git remote add "$1" "$2"
}

set_remote origin  git@git.djm.me:dave/collector.git
set_remote live    dave@summer.djm.me:collector
#set_remote staging dave@summer.djm.me:collector-staging
