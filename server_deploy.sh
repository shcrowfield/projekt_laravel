#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin deploy
    git reset --hard origin/deploy

    # Install dependencies based on lock file
    docker-compose -f docker-compose.yml exec laravel sh -c "composer update"

    # Migrate database
    docker-compose -f docker-compose.yml exec laravel sh -c "php artisan migrate"

# Exit maintenance mode
php artisan up

echo "Application deployed!"
