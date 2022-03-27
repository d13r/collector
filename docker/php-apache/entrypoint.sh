#!/bin/bash
set -o nounset -o pipefail -o errexit

if [[ ${DEBUG:-} = 'true' ]]; then
    echo "PHP debugging enabled"
    ln -nsf $PHP_INI_DIR/debug-on.ini $PHP_INI_DIR/conf.d/debug.ini
else
    echo "PHP debugging disabled"
    ln -nsf $PHP_INI_DIR/debug-off.ini $PHP_INI_DIR/conf.d/debug.ini
fi

exec docker-php-entrypoint "$@"
