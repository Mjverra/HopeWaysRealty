FROM php:8.3-cli

# Install required packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev

# Enable PHP extensions
RUN docker-php-ext-install mysqli zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first (better Docker caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
COPY . .

# Load custom PHP configuration
RUN cp /app/php.ini /usr/local/etc/php/php.ini

EXPOSE 8080

CMD ["php", "-c", "/usr/local/etc/php/php.ini", "-S", "0.0.0.0:8080", "-t", "/app"]