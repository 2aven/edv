FROM php:apache
MAINTAINER "Andreu Bió" <info.andreubio@gmail.com>
RUN  docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
RUN  docker-php-ext-install bcmath
RUN  a2enmod rewrite
RUN  a2enmod ssl
COPY --chown=www-data:www-data ./apache2_files /etc/apache2
COPY --chown=www-data:www-data ./edv /var/www/html
EXPOSE 443