#!/usr/bin/env bash
set -euo pipefail

# If port is provided, use it; otherwise auto-detect from running servers
if [ -n "${1:-}" ]; then
  PORT="$1"
else
  # Try common Laravel ports in order
  for P in 8000 8001 8080 3000; do
    if curl -fsS "http://127.0.0.1:$P" >/dev/null 2>&1; then
      PORT="$P"
      echo "Auto-detected Bellara on port $PORT"
      break
    fi
  done
  
  if [ -z "${PORT:-}" ]; then
    echo "No Bellara app detected on ports 8000, 8001, 8080, or 3000"
    echo "Start Bellara first: php artisan serve"
    exit 1
  fi
fi

ORIGIN_URL="http://127.0.0.1:${PORT}"

if ! command -v cloudflared >/dev/null 2>&1; then
  echo "cloudflared is not installed. Install it first: brew install cloudflared"
  exit 1
fi

if ! curl -fsS "$ORIGIN_URL" >/dev/null 2>&1; then
  echo "No app detected at $ORIGIN_URL"
  echo "Start Bellara first (example): php artisan serve --port=${PORT}"
  exit 1
fi

echo "Starting Cloudflare quick tunnel to $ORIGIN_URL"
echo "Press Ctrl+C to stop the tunnel."

exec cloudflared tunnel --url "$ORIGIN_URL"
