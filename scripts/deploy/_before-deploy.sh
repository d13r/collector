#!/bin/bash
set -o nounset -o pipefail -o errexit
cd "$(dirname "$0")/../.."

################################################################################
# This script is called by each of the deploy scripts.
################################################################################

source 'scripts/_includes/ask.sh'
source 'scripts/_includes/colors.sh'

#---------------------------------------
# Check Git status
#---------------------------------------

if [[ -n $(git status --porcelain) ]]; then
    red bold >&2 'Error: There are uncommitted local changes'
    exit 1
fi

#---------------------------------------
# Ask questions
#---------------------------------------

runPhpUnit=false
if [[ -f scripts/phpunit.sh && -f vendor/bin/phpunit ]] && ask 'Run PHPUnit (PHP) tests?' Y; then
    runPhpUnit=true
fi

runJest=false
if [[ -f scripts/jest.sh && -f node_modules/.bin/jest ]] && ask 'Run Jest (JavaScript) tests?' Y; then
    runJest=true
fi

runCypress=false
if [[ -f scripts/cypress.sh && -f node_modules/.bin/cypress ]] && ask 'Run Cypress (end-to-end) tests?' Y; then
    runCypress=true
fi

#---------------------------------------
# Run tests
#---------------------------------------

# Due to 'errexit' this will exit if tests fail
if $runPhpUnit; then
    echo
    green bold 'Running PHPUnit...'
    scripts/phpunit.sh
fi

if $runJest; then
    echo
    green bold 'Running Jest...'
    scripts/jest.sh --verbose --passWithNoTests
fi

if $runCypress; then
    echo
    green bold 'Running Cypress...'
    scripts/cypress.sh run --browser chromium --headless
fi

echo
