#!/bin/bash
set -o nounset -o pipefail -o errexit
cd "$(dirname "$0")/.."

################################################################################
# On the development server:
# Set the file permissions correctly for our (Ubuntu) development servers
# (owned by $USER:www, group writable and group sticky).
################################################################################

if [ "${DEPLOYING:-}" = 1 ]; then
    deploying=true
else
    deploying=false
fi

maybe_suppress_errors() {
    if $deploying; then
        eval "$@" 2>/dev/null || true
    else
        eval "$@"
    fi
}

# Sanity check
if [[ -d /var/cpanel ]]; then
    echo 'The permissions-for-development script is not compatible with cPanel servers' >&2
    exit 1
fi

# Ownership
if ! $deploying; then
    echo "Taking ownership of files..."
    if grep -q "^www:" /etc/group; then
        group='www'
    else
        group=$USER
    fi
    sudo chown -R $USER:$group ..
fi

# Permissions
echo "Setting permissions..."
maybe_suppress_errors chmod ug+rwX,o-rwx -R ..

# Make sure the scripts are all executable
maybe_suppress_errors chmod +x -R scripts

# Group sticky (new files owned by 'www' group instead of the current user)
echo "Setting sticky bit on directories..."
maybe_suppress_errors find .. -type d -exec chmod g+s '{}' +

echo "Done."
