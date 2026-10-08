FROM php:8.4-rc-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libxslt1-dev libxml2-dev && \
    docker-php-ext-install xsl && \
    docker-php-ext-enable xsl && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

RUN mkdir -p /var/www/html/xml /var/www/html/images && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

RUN echo "upload_max_filesize = 10M\npost_max_size = 12M" > /usr/local/etc/php/conf.d/uploads.ini
