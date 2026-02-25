FROM php:8.3-cli-alpine

# Install dependencies and extensions
RUN apk add --no-cache bash git unzip curl icu-dev

# Use mlocati to easily install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_pgsql amqp redis intl zip opcache @composer

WORKDIR /app
