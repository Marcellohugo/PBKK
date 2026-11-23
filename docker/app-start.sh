#!/bin/sh
set -eu

attempt=0
until pg_isready -q -h /run/postgresql -U "${DB_USERNAME:-postgres}" -d postgres; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge 60 ]; then
        echo 'PostgreSQL is not ready.' >&2
        exit 1
    fi
    sleep 1
done

runuser -u postgres -- psql --no-psqlrc --username="${DB_USERNAME:-postgres}" --dbname=postgres --set=db_name="${DB_DATABASE:-pbkk}" <<'SQL'
SELECT format('CREATE DATABASE %I', :'db_name')
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = :'db_name') \gexec
SQL

cd /app
runuser -u www-data -- php artisan config:clear --no-interaction
runuser -u www-data -- php artisan migrate --force --no-interaction

cd /app/public
exec runuser -u www-data -- php -S 0.0.0.0:8000 /app/vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php
