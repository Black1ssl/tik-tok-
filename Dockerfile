FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    yt-dlp \
    python3 \
    ffmpeg \
    && rm -rf /var/lib/apt/lists/*

RUN echo "disable_functions =" > /usr/local/etc/php/conf.d/custom.ini

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
