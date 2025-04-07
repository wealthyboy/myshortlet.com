#!/bin/bash

cd /home/forge/avenuemontaigne.ng || exit

# Use the full path to git just in case
/usr/bin/git pull origin master

# Use the full path to composer
/usr/local/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Restart PHP-FPM
( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service php8.2-fpm reload ) 9>/tmp/fpmlock

# Run migrations
if [ -f artisan ]; then
    /usr/bin/php artisan migrate --force
fi

# Build assets
/usr/bin/npm run prod
