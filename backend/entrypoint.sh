#!/bin/bash
set -e

echo "🚀 Avvio container Laravel..."

# Aspetta che MySQL sia pronto
echo "⏳ Attendo che MySQL sia disponibile su $DB_HOST:$DB_PORT..."
while ! nc -z "$DB_HOST" "$DB_PORT"; do
    sleep 1
done
echo "✅ MySQL è pronto!"

cd /var/www

# Imposta i permessi per Laravel
echo "🔧 Imposto i permessi..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Installa le dipendenze PHP (solo se manca vendor)
if [ ! -d "vendor" ]; then
    echo "📦 Installo dipendenze PHP..."
    composer install --no-interaction --no-progress
else
    echo "📦 Dipendenze già presenti."
fi

# Rimuovi eventuali cache precedenti
php artisan optimize:clear

# Genera il file .env dinamicamente
echo "📝 Genero file .env..."
cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=${APP_ENV:-local}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-true}
APP_URL=http://localhost:8000
LOG_CHANNEL=stack
DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
EOF

# Genera una nuova chiave solo se manca
if [ -z "${APP_KEY}" ]; then
    php artisan key:generate
fi

# ---------------------------------------------------------------------
# 🧱 DATABASE: reset automatico SOLO in ambiente local
# ---------------------------------------------------------------------
if [ "$APP_ENV" = "local" ]; then
    echo "🧹 Ambiente local: reset completo del database..."
    echo "⚙️ Reset DB tramite Artisan..."
    php artisan migrate:fresh --seed --force
else
    echo "🏭 Ambiente production: eseguo migrazioni e seed senza cancellare il DB..."
    php artisan config:cache
    php artisan route:cache
    php artisan migrate --force
    php artisan db:seed --force
fi

# Avvia php-fpm e nginx
echo "🚀 Avvio php-fpm e nginx..."
php-fpm -R -F -O &
nginx -g 'daemon off;'
