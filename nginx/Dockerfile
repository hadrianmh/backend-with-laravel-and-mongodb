# create web server php-fpm with nginx (include extension)
FROM php:8.2-fpm-buster

# Install Nginx
RUN apt update -y
RUN apt install nginx supervisor -y
RUN mkdir -p /var/log/php-fpm/

# Create conf PHP & Nginx
COPY ./nginx/default.conf /etc/nginx/sites-enabled/default.conf
COPY ./nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./src/ /var/www/html/
RUN ln -sf /dev/stdout /var/log/nginx/access.log && ln -sf /dev/stderr /var/log/nginx/error.log
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions mongodb zip

# Create permission in Laravel log
WORKDIR /var/www/html
RUN chmod 777 storage/ -R

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer update

CMD [ "/usr/bin/supervisord" ]