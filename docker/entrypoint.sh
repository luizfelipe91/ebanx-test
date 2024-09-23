#!/usr/bin/env bash
set -e

echo "Starting..."

echo "alias art='php artisan'" >> ~/.bashrc

exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf

exec tail -f /dev/null
