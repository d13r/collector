#!/bin/bash
set -o nounset -o pipefail -o errexit

################################################################################
# Run Composer.
################################################################################

root="$(dirname "$0")/.."

exec "$root/scripts/php.sh" composer "$@"
