FROM php:8.2-apache

# Apache rewrite
RUN a2enmod rewrite

# Composer o‘rnatish
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Composer install
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader

# Loyiha fayllari
COPY . .

# Ruxsatlar
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
