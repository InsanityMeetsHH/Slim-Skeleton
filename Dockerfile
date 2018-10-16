#FROM nyanpass/php5.5:5.5-alpine
FROM php:7-alpine
RUN docker-php-ext-install pdo pdo_mysql
