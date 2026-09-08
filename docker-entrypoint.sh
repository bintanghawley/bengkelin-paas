#!/bin/sh
set -e

# Update Apache port dynamically if PORT is provided by Railway
if [ -n "$PORT" ]; then
    sed -ri -e "s/Listen [0-9]+/Listen $PORT/" /etc/apache2/ports.conf
    sed -ri -e "s/<VirtualHost \*:[0-9]+>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf
fi

echo "=== [Bengkelin Startup] ==="
echo "Port: ${PORT:-80}"

# Optimize DNS resolver in container to prevent AAAA IPv6 timeouts
echo "options single-request timeout:1" >> /etc/resolv.conf 2>/dev/null || true

# Pre-resolve database host into /etc/hosts to eliminate DNS query latency
if [ -n "$DATABASE_URL" ]; then
    DB_HOST_PARSED=$(php -r '$url = parse_url(getenv("DATABASE_URL")); echo $url["host"] ?? "";' 2>/dev/null || true)
    if [ -n "$DB_HOST_PARSED" ]; then
        echo "Pre-resolving database host ($DB_HOST_PARSED)..."
        DB_IPV4=$(php -r '$ip = gethostbyname("'"$DB_HOST_PARSED"'"); if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) echo $ip;' 2>/dev/null || true)
        if [ -n "$DB_IPV4" ]; then
            echo "$DB_IPV4 $DB_HOST_PARSED" >> /etc/hosts 2>/dev/null || true
            echo "DNS fast-path: mapped $DB_HOST_PARSED -> $DB_IPV4"
        fi
    fi
fi

# Run package discovery with runtime environment variables
echo "Running package discovery..."
php artisan package:discover --ansi || true

# Clear old cache
echo "Clearing application cache..."
php artisan optimize:clear || true

# Run database migrations automatically
echo "Running database migrations..."
php artisan migrate --force || echo "[WARNING] Migration failed! Check DATABASE_URL and database connectivity."

# Ensure storage directories, symlink, and permissions exist
mkdir -p /var/www/html/storage/app/public/tires \
         /var/www/html/storage/app/public/oils \
         /var/www/html/storage/app/public/spareparts \
         /var/www/html/storage/app/public/services \
         /var/www/html/storage/app/public/products
php artisan storage:link --force || true
chown -R www-data:www-data /var/www/html/storage 2>/dev/null || true
chmod -R 775 /var/www/html/storage 2>/dev/null || true

# Cache configuration, routes, and views for high performance
echo "Caching configuration, routes, and views..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Ensure only mpm_prefork is loaded
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

echo "Starting Apache web server..."

# Start Apache in foreground
exec apache2-foreground
