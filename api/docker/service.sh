#!/bin/sh
nginx -g "error_log /dev/stdout info;"
php-fpm --force-stderr --nodaemonize
