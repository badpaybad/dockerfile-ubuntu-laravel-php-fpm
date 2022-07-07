FROM ubuntu:20.04

# Download script to install PHP extensions and dependencies if use FROM php:8.0-fpm
# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# RUN chmod uga+x /usr/local/bin/install-php-extensions && sync
# RUN install-php-extensions dom curl 7zip unzip

RUN apt update && apt -y upgrade && apt install -y lsb-release ca-certificates apt-transport-https software-properties-common

RUN apt install -y bash nginx zip unzip htop nano imagemagick curl 
#php8.0
RUN add-apt-repository ppa:ondrej/php && apt install -y php8.0
#php8 extension
RUN apt install -y php8.0-fpm php8.0-opcache php8.0-gd \
    php8.0-curl php8.0-xml php8.0-mbstring php8.0-zip \
    php8.0-cli php8.0-common php8.0-redis \
    php8.0-imap php8.0-snmp php8.0-soap \
    php8.0-mysql php8.0-pgsql php8.0-mongodb \
    php8.0-imagick     

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt clean -y

COPY server/etc/nginx /etc/nginx

COPY server/etc/php /etc/php8

COPY server/etc/php/8.0/cli/php.ini /etc/php/8.0/cli/php.ini
COPY server/etc/php/8.0/fpm/php.ini /etc/php/8.0/fpm/php.ini
COPY server/etc/php/8.0/fpm/php-fpm.conf /etc/php/8.0/fpm/php-fpm.conf
COPY server/etc/php/8.0/fpm/pool.d/www.conf /etc/php/8.0/fpm/pool.d/www.conf

##your source
COPY ./ /usr/share/nginx/html/

# COPY ./.env.example /usr/share/nginx/html/.env

WORKDIR /usr/share/nginx/html/
ENV COMPOSER_ALLOW_SUPERUSER 1
#RUN composer install
RUN composer update

RUN mkdir /var/run/php
EXPOSE 80
#EXPOSE 443

STOPSIGNAL SIGTERM
## check user run fpm : server/etc/php/8.0/fpm/pool.d/www.conf
# RUN groupadd -r www-data
# RUN useradd -r -s /sbin/nologin -d /dev/null -g www-data www-data
#server\etc\nginx\nginx.conf we run as root
#RUN groupadd -r nginx
#RUN useradd -r -s /sbin/nologin -d /dev/null -g nginx nginx

#RUN chmod 777 /usr/share/nginx/html/
#RUN chmod -R 777 /usr/share/nginx/html/storage

RUN chown -R www-data:www-data /usr/share/nginx/html/storage/
RUN chmod -R 775 /usr/share/nginx/html/storage/

RUN chown -R www-data:www-data /usr/share/nginx/html/public/
RUN chmod -R 775 /usr/share/nginx/html/public/

CMD ["/bin/bash", "-c", "php-fpm8.0 && chmod 777 /var/run/php/php8.0-fpm.sock && nginx -g 'daemon off;'"]

# docker build -t testlaravel .
# docker run -d -p 8889:80 testlaravel 