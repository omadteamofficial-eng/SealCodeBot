FROM php:8.2-apache

# Apache rewrite yoqish (ko‘p PHP loyihalar uchun kerak bo‘ladi)
RUN a2enmod rewrite

# Loyiha fayllarini Apache papkasiga ko‘chirish
COPY . /var/www/html/

# Ruxsatlarni to‘g‘rilash
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
