FROM php:8.2-apache

# Apache modullar
RUN a2enmod rewrite

# Kerakli PHP extensionlar
RUN docker-php-ext-install curl

# Composer o‘rnatish
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ishchi papka
WORKDIR /var/www/html

# Avval composer.json (cache uchun)
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader

# Keyin barcha fayllar
COPY . .

# Ruxsatlar
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
