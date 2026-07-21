#!/bin/sh
set -eu
PORT="${PORT:-8080}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
cat > /var/www/html/index.html <<'EOF'
<!doctype html><meta http-equiv="refresh" content="0; url=/version_final/"><title>La Pesquera</title>
EOF
exec apache2-foreground
