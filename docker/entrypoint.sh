#!/bin/bash

echo "Fixing permissions for Laravel..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

echo "Checking Nginx configuration..."
nginx -t

echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
