FROM ubuntu:noble

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        gnupg curl ca-certificates software-properties-common locales \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml \
        php8.3-curl php8.3-bcmath php8.3-gd php8.3-zip \
        mysql-client git unzip \
    && curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public/", "public/index.php"]
