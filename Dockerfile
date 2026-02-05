FROM php:8.2-apache

# Install dependency
RUN apt-get update && apt-get install -y \
    yt-dlp \
    python3 \
    ffmpeg \
    && rm -rf /var/lib/apt/lists/*

# Aktifkan shell_exec
RUN echo "disable_functions =" > /usr/local/etc/php/conf.d/custom.ini

# Copy file PHP ke Apache
COPY . /var/www/html/

# Permission
RUN chown -R www-data:www-data /var/www/html
