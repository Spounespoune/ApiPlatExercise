FROM php:8.4-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    zip

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Exposer le port (facultatif)
EXPOSE 9000

CMD ["php-fpm"]