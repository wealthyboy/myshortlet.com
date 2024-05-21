#!/bin/bash

# Change to the project directory
cd /home/forge/avenuemontaigne.ng || exit


# Turn on maintenance mode
php artisan down || true

git pull origin master


# Install/update composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear

# Clear expired password reset tokens
php artisan auth:clear-resets

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache

# Install node modules
# npm install

# Build assets using Laravel Mix
npm run production

# Turn off maintenance mode
php artisan up
