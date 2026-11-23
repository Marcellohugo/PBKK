#!/bin/sh
set -eu

attempt=0
until ollama list >/dev/null 2>&1; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge 60 ]; then
        echo 'Ollama is not ready.' >&2
        exit 1
    fi
    sleep 1
done

if ! ollama show "${OLLAMA_MODEL:-qwen3.5:2b}" >/dev/null 2>&1; then
    exec ollama pull "${OLLAMA_MODEL:-qwen3.5:2b}"
fi
