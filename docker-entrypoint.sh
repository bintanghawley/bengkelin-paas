#!/bin/sh
set -e

# Update Apache port dynamically if PORT is provided by Railway
if [ -n "$PORT" ]; then
    sed -ri -e "s/Listen [0-9]+/Listen $PORT/" /etc/apache2/ports.conf
    sed -ri -e "s/<VirtualHost \*:[0-9]+>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf
fi

echo "=== [Bengkelin Startup] ==="
echo "Port: ${PORT:-80}"

# Run package discovery with runtime environment variables
echo "Running package discovery..."
php artisan package:discover --ansi || true

# Clear old cache
echo "Clearing application cache..."
php artisan optimize:clear || true

# Run database migrations automatically
echo "Running database migrations..."
php artisan migrate --force || echo "[WARNING] Migration failed! Check DATABASE_URL and database connectivity."

# Ensure only mpm_prefork is loaded
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

echo "Starting Apache web server..."

# Start Apache in foreground
exec apache2-foreground
