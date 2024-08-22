FROM  php:8.1.29-apache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Vérifier la version de Composer pour s'assurer qu'il est installé correctement
RUN composer --version

COPY . /var/www/

COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Définir COMPOSER_ALLOW_SUPERUSER pour permettre l'exécution de Composer en tant que root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer les dépendances de Composer
RUN cd /var/www && composer install

RUN chown -R www-data:www-data /var/www/var && \
    chmod -R 775 /var/www/var

WORKDIR /var/www/

EXPOSE 80
