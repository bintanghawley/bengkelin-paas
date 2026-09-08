#!/bin/sh
set -e

# Update Apache port dynamically if PORT is provided by Railway
if [ -n "$PORT" ]; then
    sed -ri -e "s/Listen [0-9]+/Listen $PORT/" /etc/apache2/ports.conf
    sed -ri -e "s/<VirtualHost \*:[0-9]+>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf
fi

# Clear old cache
php artisan optimize:clear || true

# Run database migrations automatically
echo "Running database migrations..."
php artisan migrate --force || true

# Start Apache in foreground
exec apache2-foreground
