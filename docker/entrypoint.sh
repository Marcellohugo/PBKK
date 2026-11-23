#!/bin/sh
set -eu

cd /app
mkdir -p storage/app/private storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data storage bootstrap/cache
mkdir -p "$PGDATA" /run/postgresql
chown -R postgres:postgres "$PGDATA" /run/postgresql
chmod 700 "$PGDATA"

if [ ! -s "$PGDATA/PG_VERSION" ]; then
    : "${DB_PASSWORD:?Set DB_PASSWORD in .env}"
    (umask 077 && printf '%s\n' "$DB_PASSWORD" > /run/postgresql/init-password)
    chown postgres:postgres /run/postgresql/init-password
    runuser -u postgres -- initdb -D "$PGDATA" --username="${DB_USERNAME:-postgres}" \
        --encoding=UTF8 --locale=en_US.UTF-8 \
        --pwfile=/run/postgresql/init-password --auth-local=trust --auth-host=scram-sha-256
    rm /run/postgresql/init-password
fi

key_file=storage/app/docker-app-key
if [ -n "${APP_KEY:-}" ] || [ ! -s "$key_file" ]; then
    (umask 077 && php -r 'echo getenv("APP_KEY") ?: "base64:".base64_encode(random_bytes(32));' > "$key_file.tmp")
    chmod 600 "$key_file.tmp"
    chown www-data:www-data "$key_file.tmp"
    mv "$key_file.tmp" "$key_file"
fi

exec /usr/bin/supervisord -c /app/docker/supervisord.conf
