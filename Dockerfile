FROM	php:apache
RUN	docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql bcmath
RUN a2enmod ssl
COPY apache2_files /etc/apache2
COPY edv /var/www/html
EXPOSE 443