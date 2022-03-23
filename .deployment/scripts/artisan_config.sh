#!/bin/bash
php /var/www/app-4bb61698/artisan config:clear
php /var/www/app-4bb61698/artisan config:cache
php /var/www/app-4bb61698/artisan route:cache
php /var/www/app-4bb61698/artisan view:cache
