#!/bin/bash
set -o nounset -o pipefail -o errexit
cd "$(dirname "$0")/.."

################################################################################
# On the live server:
# Set file permissions correctly for the live server.
################################################################################

if [[ ${DEPLOYING:-} = 1 ]]; then
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

if [[ -f /etc/issue ]] && grep -q Ubuntu /etc/issue; then

    # Ubuntu server
    if [[ $PWD = /home/www/*/repo ]]; then
        # Update the config and log files as well
        root=..
    else
        root=.
    fi

    if ! $deploying; then
        echo 'Taking ownership of files...'
        if grep -q "^www:" /etc/group; then
            group='www'
        else
            group=$USER
        fi
        sudo chown -R $USER:$group $root
    fi

    echo 'Setting permissions...'
    maybe_suppress_errors chmod ug+rwX,o-rwx -R $root

    echo 'Setting sticky bit on directories...'
    maybe_suppress_errors find $root -type d -exec chmod g+s '{}' +

elif [[ -d /var/cpanel ]]; then

    # cPanel server
    if hostname -f | grep -q '\.\(guru\.net\.uk\|myukcloud\.com\)'; then

        # Guru servers don't use the user account for the web server (LiteSpeed), only for PHP
        echo 'Setting permissions...'
        maybe_suppress_errors chmod u+rwX,g+rX-w,o+rX-w -R .
        maybe_suppress_errors find . -name '\*.php' -exec chmod o-rwx '{}' +

    elif hostname -f | grep -q '\.alberon\.\(co\.uk\|net\)'; then

        # On our servers, Apache (via ModRuid2) and PHP-FPM both run under the user account
        echo 'Setting permissions...'
        maybe_suppress_errors chmod u+rwX,g+rX-w,o-rwx -R .

    else

        # Unknown cPanel server
        echo 'Cannot determine the cPanel server type' >&2
        exit 1

    fi

else

    # Unknown OS
    echo 'Cannot determine the server operating system' >&2
    exit 1

fi

echo "Done."
