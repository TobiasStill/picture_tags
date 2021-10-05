FROM php:8-apache

RUN a2enmod ssl && a2enmod rewrite
RUN mkdir -p /etc/apache2/ssl
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN DEBIAN_FRONTEND=noninteractive apt-get update \
	&& apt-get install -y --no-install-recommends \
	&& pecl install xdebug-3.0.0 \
	&& docker-php-ext-enable xdebug \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy custom config to PHP config dir.
COPY php-config/custom.ini "$PHP_INI_DIR/conf.d/"

COPY ./ssl/cert.pem /etc/apache2/ssl/
COPY ./ssl/cert-key.pem /etc/apache2/ssl/
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
EXPOSE 443
