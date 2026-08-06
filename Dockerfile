FROM php:8.3-cli

WORKDIR /app

COPY . .

RUN docker-php-ext-install mysqli

# Copy php.ini
RUN cp /app/php.ini /usr/local/etc/php/php.ini

EXPOSE 8080

CMD ["php", "-c", "/usr/local/etc/php/php.ini", "-S", "0.0.0.0:8080", "-t", "/app"]