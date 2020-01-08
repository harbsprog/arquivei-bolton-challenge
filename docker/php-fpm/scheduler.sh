#!/bin/bash

# Run Laravel Essential Commands
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
cd /var/www/html && composer install &
cp /var/www/html/.env.example .env 
php /var/www/html/artisan key:generate &
php /var/www/html/artisan migrate &

# Run Laravel Jobs Processing
php /var/www/html/artisan queue:work --queue=nfeSync &

# Run scheduler and Queue retry every minute
while [ true ]
do
  php /var/www/html/artisan schedule:run --verbose --no-interaction
  php /var/www/html/artisan queue:retry all
  sleep 60
done