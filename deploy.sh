#!/bin/bash

set -e

cd /home/forge/avenuemontaigne.ng || exit

# Stash local changes to avoid conflicts
/usr/bin/git reset --hard
/usr/bin/git clean -fd
/usr/bin/git fetch origin master
/usr/bin/git reset --hard origin/master

/usr/local/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan queue:restart


