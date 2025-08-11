#!/bin/bash

cd /home/forge/avenuemontaigne.ng || exit

# Stash local changes to avoid conflicts
/usr/bin/git reset --hard
/usr/bin/git clean -fd
/usr/bin/git fetch origin master
/usr/bin/git reset --hard origin/master

/usr/local/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service php8.2-fpm reload ) 9>/tmp/fpmlock

if [ -f artisan ]; then
    /usr/bin/php artisan migrate --force
fi

/usr/bin/npm run prod
