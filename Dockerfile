FROM php:8.3-cli

WORKDIR /app

COPY . .

RUN docker-php-ext-install mysqli

EXPOSE 8080

CMD sh -c "php -S 0.0.0.0:${PORT:-8080} -t /app"