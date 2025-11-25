FROM php:8.3-apache

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy the migration script
COPY docs/sql/role_user.sql /var/www/html/sql/role_user.sql

# Install PDO PostgreSQL driver and basic tools
RUN apt-get update && apt-get install -y \
    libpq-dev \
    curl gnupg && \
    docker-php-ext-install pdo_pgsql && \
    rm -rf /var/lib/apt/lists/*

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Add Node.js (via Nodesource)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs && \
    node -v && npm -v

# Copy the custom Apache configuration
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
# Copy custom PHP configuration
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Copy package files
COPY package*.json ./

# Ensure the Apache configuration is properly enabled
RUN apachectl configtest
