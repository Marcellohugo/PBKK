FROM php:8.4-cli-bookworm AS php-base

RUN apt-get update \
    && apt-get install -y --no-install-recommends ca-certificates curl unzip supervisor libpq-dev libonig-dev libicu-dev libsqlite3-dev \
    && curl -fsSL https://www.postgresql.org/media/keys/ACCC4CF8.asc -o /usr/share/keyrings/postgresql.asc \
    && echo 'deb [signed-by=/usr/share/keyrings/postgresql.asc] https://apt.postgresql.org/pub/repos/apt bookworm-pgdg main' > /etc/apt/sources.list.d/postgresql.list \
    && mkdir -p /etc/postgresql-common \
    && echo 'create_main_cluster = false' > /etc/postgresql-common/createcluster.conf \
    && apt-get update \
    && apt-get install -y --no-install-recommends postgresql-16 \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql pdo_sqlite mbstring intl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

FROM ollama/ollama:0.40.1 AS ollama-cpu
RUN mkdir -p /cpu/lib \
    && cp -a /usr/lib/ollama/*.so* /cpu/lib/ \
    && cp /usr/lib/ollama/llama-server /cpu/lib/ \
    && cp /usr/lib/ollama/*LICENSE* /cpu/lib/

FROM php-base AS dependencies
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-interaction --no-progress --no-scripts

FROM node:24-bookworm-slim AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
RUN npm run build

FROM php-base AS application
COPY . .
COPY --from=dependencies /app/vendor ./vendor
COPY --from=frontend /app/node_modules ./node_modules
COPY --from=frontend /app/public/build ./public/build
RUN mkdir -p storage/app/private storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && php artisan package:discover --no-interaction \
    && php artisan adminlte:install --only=assets --only=vendor_assets --only=translations --no-interaction \
    && rm -rf node_modules \
    && chmod +x docker/*.sh

FROM php-base AS runtime
RUN apt-get update \
    && apt-get install -y --no-install-recommends locales \
    && localedef -i en_US -f UTF-8 en_US.UTF-8 \
    && rm -rf /var/lib/apt/lists/*
COPY --from=application /app /app
COPY --from=ollama-cpu /bin/ollama /usr/bin/ollama
COPY --from=ollama-cpu /cpu/lib /usr/lib/ollama
RUN chown -R www-data:www-data storage bootstrap/cache
ENV PGDATA=/var/lib/postgresql/data
ENV PATH=/usr/lib/postgresql/16/bin:$PATH
EXPOSE 8000
ENTRYPOINT ["/app/docker/entrypoint.sh"]
HEALTHCHECK --interval=10s --timeout=5s --start-period=60s --retries=6 \
    CMD /app/docker/healthcheck.sh
