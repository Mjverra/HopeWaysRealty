FROM php:8.3-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy website files into Apache
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Give Apache permission to read files
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80