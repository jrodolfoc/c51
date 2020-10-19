FROM php:fpm-alpine

RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www

CMD COMPOSER_MEMORY_LIMIT=-1 composer install ; \
  php bin/console doctrine:migrations:migrate -n -v ; \
  php bin/console app:populate-offers c51.json ; \
  php-fpm

EXPOSE 9000