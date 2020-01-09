#!/bin/bash

# Run Laravel Essential Commands
docker-compose exec arquivei-php chmod -R 775 storage
docker-compose exec arquivei-php chmod -R 775 bootstrap/cache
docker-compose exec arquivei-php composer install
docker-compose exec arquivei-php cp .env.example .env 
docker-compose exec arquivei-php php artisan key:generate
docker-compose exec arquivei-php php artisan migrate

# Run Laravel Jobs Processing
docker-compose exec arquivei-php php artisan queue:work --queue=nfeSync

# Run scheduler and Queue retry every minute
while [ true ]
do
  docker-compose exec arquivei-php php artisan schedule:run --verbose --no-interaction
  docker-compose exec arquivei-php  php artisan queue:retry all
  sleep 60
done