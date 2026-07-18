#!/bin/sh
set -e

if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generate one with:"
    echo "  docker run --rm \$(docker build -q .) php artisan key:generate --show"
    echo "and put it in .env as APP_KEY=base64:..."
    exit 1
fi

# No config/route/view caching here — code is bind-mounted for live editing,
# and caching would serve stale compiled output until manually cleared.
php artisan config:clear
php artisan route:clear
php artisan view:clear

if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force
fi

exec "$@"
