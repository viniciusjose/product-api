FROM php:8.3-fpm

ARG USER
ARG USER_ID
ARG GROUP_ID
ARG timezone="America/Sao_Paulo"

ENV TIMEZONE=$timezone
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    vim \
    libicu-dev \
    iputils-ping \
    telnet \
    libpq-dev \
    && install-php-extensions @composer decimal pdo  pdo_pgsql pgsql intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configurar usuário
RUN groupadd --force -g $GROUP_ID $USER \
    && useradd -ms /bin/bash --no-user-group -g $GROUP_ID -u 1337 $USER \
    && usermod -u $USER_ID $USER

COPY --chown=$USER:$USER . .

RUN composer install --no-interaction --optimize-autoloader --no-scripts

USER $USER

CMD ["php-fpm"]