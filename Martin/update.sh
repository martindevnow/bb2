#!/bin/bash

# make sure we're in the right directory
cd ~/projects/bb2

# update the repo
git pull origin dev

# update dependencies
composer update

# Update the database for dev
php artisan migrate:refresh --seed