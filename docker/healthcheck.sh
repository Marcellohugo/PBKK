#!/bin/sh
set -eu

pg_isready -q -h 127.0.0.1 -U "${DB_USERNAME:-postgres}" -d "${DB_DATABASE:-pbkk}"
ollama list >/dev/null
php -r 'exit(@file_get_contents("http://127.0.0.1:8000/login") === false ? 1 : 0);'
