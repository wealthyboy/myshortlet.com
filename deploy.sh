#!/bin/bash

cd /home/forge/avenuemontaigne.ng || exit

# Stash local changes to avoid conflicts
/usr/bin/git reset --hard
/usr/bin/git clean -fd
/usr/bin/git fetch origin master
/usr/bin/git reset --hard origin/master

/usr/local/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader


