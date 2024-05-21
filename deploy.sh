#!/bin/bash

# Change to the project directory
cd /home/forge/avenuemontaigne.ng || exit

# Start the SSH agent and add the id_ed25519 key
eval "$(ssh-agent -s)"
# Start the ssh-agent in the background
eval "$(ssh-agent -s)"

# Add your SSH private key to the ssh-agent
ssh-add ~/.ssh/id_ed25519 <<EOF
j1a2c3o4b5
EOF
# Turn on maintenance mode
php artisan down || true

# Check for any changes before pulling
git fetch origin master

# Pull the latest changes from the git repository
if git diff --quiet HEAD origin/master; then
  echo "Already up to date."
else
  echo "Pulling latest changes..."
  git pull origin master || { echo 'Failed to pull from Git repository'; exit 1; }
fi

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
