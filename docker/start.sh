#!/bin/sh
# Container entrypoint for Render. Runs on every boot/deploy.
set -e
cd /var/www/html

# Render sets RENDER_EXTERNAL_URL (https://<service>.onrender.com); use it unless
# APP_URL was set explicitly (e.g. a custom domain).
if [ -z "${APP_URL:-}" ] && [ -n "${RENDER_EXTERNAL_URL:-}" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

if [ -z "${APP_KEY:-}" ]; then
    echo "FATAL: APP_KEY is not set. Generate one with: php artisan key:generate --show" >&2
    exit 1
fi

# Cache config/routes/views/events with the runtime environment variables.
php artisan optimize

# Free plan has no pre-deploy command, so migrate here. --force is required in production.
# Set RUN_MIGRATIONS=false to skip (e.g. if you move this to a pre-deploy command).
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    php artisan migrate --force --no-interaction
fi

# Files created above as root must stay writable by Apache's user.
chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
