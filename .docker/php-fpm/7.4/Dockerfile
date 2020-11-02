FROM php:7.4-fpm

VOLUME /srv/cache


RUN apt-get update -qq \
    && apt-get install -y --no-install-recommends \
        git unzip libzip-dev \
    && pecl install mongodb \
    && docker-php-ext-enable \
        mongodb \
    && docker-php-ext-install -j$(nproc) \
        zip \
        mysqli \
        pdo_mysql \
    && apt-get clean \
    && pecl clear-cache \
    && rm -rf /var/lib/apt/lists/* \
        && cd -

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG DOCKER_USER
ARG DOCKER_USER_ID

# Add local user
RUN useradd --shell /bin/bash -u ${DOCKER_USER_ID} -o -c "" -m ${DOCKER_USER} \
    && adduser ${DOCKER_USER} sudo \
    && echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers \
    && export HOME=/home/${DOCKER_USER}
