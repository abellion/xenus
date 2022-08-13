FROM php:7.1-cli

# Update system and install libs
RUN apt-get update \
&& apt-get install -y libssl-dev \
&& apt-get install -y unzip \
&& apt-get clean

# Install / enable PHP extensions
RUN pecl install mongodb-1.2.0 \
&& docker-php-ext-enable mongodb

# Create Xenus dir
RUN mkdir -p /usr/src/xenus
WORKDIR /usr/src/xenus

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.17
