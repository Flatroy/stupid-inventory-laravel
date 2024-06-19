FROM dunglas/frankenphp

ENV APP_ENV=production

RUN install-php-extensions \
	pdo_mysql \
	gd \
	intl \
	zip \
	opcache

COPY . /app

#WORKDIR /app
#
#HEALTHCHECK CMD curl --fail http://localhost:80/login || exit 1
#
#ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
