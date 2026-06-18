FROM php:8.4-cli

WORKDIR /app

# install dependency
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip nodejs npm\
    && docker-php-ext-install zip pdo pdo_mysql

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .


# install backend
RUN composer install --no-dev --optimize-autoloader

# install frontend + build vite
RUN npm install && npm run build

# expose port
EXPOSE 8080

# run app
CMD php artisan serve --host=0.0.0.0 --port=8080
