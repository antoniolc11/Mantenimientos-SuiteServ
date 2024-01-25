#!/bin/bash

# Clonar el repositorio
git clone https://github.com/antoniolc11/Mantenimientos-SuiteServ.git
cd Mantenimientos-SuiteServ

# Generar la clave del nuevo usuario para postgres
sudo -u postgres createuser -P antoniolc11

# Generar la base de datos
sudo -u postgres createdb -O antoniolc11 SuiteServ_BD

# Instalar dependencias de Composer
composer install

# Instalar dependencias de npm y compilar assets
npm install

# Copiar el archivo .env.example a .env
cp .env.example .env

# Generar la clave de la aplicación
php artisan key:generate

# Configurar el archivo .env con tus valores
echo "APP_NAME=Mantenimientos-SuiteServ" > .env
echo "APP_ENV=local" >> .env
echo "APP_KEY=base64:keJkGXtPnIHb/arw7ogmRmP8yzFC1eTyL37Roo4a37g=" >> .env
echo "APP_DEBUG=true" >> .env
echo "APP_URL=http://localhost" >> .env
echo "" >> .env

echo "LOG_CHANNEL=stack" >> .env
echo "LOG_DEPRECATIONS_CHANNEL=null" >> .env
echo "LOG_LEVEL=debug" >> .env
echo "" >> .env

echo "DB_CONNECTION=pgsql" >> .env
echo "DB_HOST=127.0.0.1" >> .env
echo "DB_PORT=5432" >> .env
echo "DB_DATABASE=SuiteServ_BD" >> .env
echo "DB_USERNAME=antoniolc11" >> .env
echo "DB_PASSWORD=proyecto" >> .env
echo "" >> .env

echo "BROADCAST_DRIVER=log" >> .env
echo "CACHE_DRIVER=file" >> .env
echo "FILESYSTEM_DISK=local" >> .env
echo "QUEUE_CONNECTION=sync" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "SESSION_LIFETIME=120" >> .env
echo "" >> .env

echo "MEMCACHED_HOST=127.0.0.1" >> .env
echo "" >> .env

echo "REDIS_HOST=127.0.0.1" >> .env
echo "REDIS_PASSWORD=null" >> .env
echo "REDIS_PORT=6379" >> .env
echo "" >> .env

echo "MAIL_MAILER=smtp" >> .env
echo "MAIL_HOST=smtp.gmail.com" >> .env
echo "MAIL_PORT=587" >> .env
echo "MAIL_USERNAME=email" >> .env
echo "MAIL_PASSWORD=password" >> .env
echo "MAIL_ENCRYPTION=tls" >> .env
echo 'MAIL_FROM_ADDRESS="SuiteServ@example.com"' >> .env
echo 'MAIL_FROM_NAME="${APP_NAME}"' >> .env
echo "" >> .env

# Configuraciones de AWS
echo "AWS_ACCESS_KEY_ID=" >> .env
echo "AWS_SECRET_ACCESS_KEY=" >> .env
echo "AWS_DEFAULT_REGION=us-east-1" >> .env
echo "AWS_BUCKET=" >> .env
echo "AWS_USE_PATH_STYLE_ENDPOINT=false" >> .env
echo "" >> .env

# Configuraciones de Pusher
echo "PUSHER_APP_ID=" >> .env
echo "PUSHER_APP_KEY=" >> .env
echo "PUSHER_APP_SECRET=" >> .env
echo "PUSHER_HOST=" >> .env
echo "PUSHER_PORT=443" >> .env
echo "PUSHER_SCHEME=https" >> .env
echo "PUSHER_APP_CLUSTER=mt1" >> .env
echo "" >> .env

# Configuraciones para Vite
echo "VITE_APP_NAME=\${APP_NAME}" >> .env
echo "VITE_PUSHER_APP_KEY=\${PUSHER_APP_KEY}" >> .env
echo "VITE_PUSHER_HOST=\${PUSHER_HOST}" >> .env
echo "VITE_PUSHER_PORT=\${PUSHER_PORT}" >> .env
echo "VITE_PUSHER_SCHEME=\${PUSHER_SCHEME}" >> .env
echo "VITE_PUSHER_APP_CLUSTER=\${PUSHER_APP_CLUSTER}" >> .env

# Ejecutar migraciones
php artisan migrate:refresh --seed

#crea un enlace simbólico entre la carpeta public y la carpeta storage/app/public
php artisan storage:link

# Iniciar el servidor de desarrollo de Laravel en una nueva pestaña
gnome-terminal --tab -- php artisan serve

# Abrir una nueva pestaña de la consola y ejecutar npm run dev
gnome-terminal --tab -- npm run dev

# Salida informativa para el usuario
echo "La aplicación Laravel se ha desplegado. Puedes acceder a ella en http://localhost:8000"

