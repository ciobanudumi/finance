#!/usr/bin/env sh
set -e

./place-env-vars.sh /usr/share/nginx/html

nginx -g 'daemon off;'
