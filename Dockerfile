FROM alpine:latest

LABEL maintainer="alexsabur@live.ru"

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk -U upgrade && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ \
    supervisor \
    nginx \
    bash \
    envsubst \
    php81  \
    php81-bcmath  \
    php81-brotli \
    php81-bz2  \
    php81-calendar  \
    php81-common  \
    php81-ctype  \
    php81-curl  \
    php81-dba  \
    php81-dom  \
    php81-embed  \
    php81-enchant  \
    php81-exif  \
    php81-ffi  \
    php81-fileinfo  \
    php81-fpm  \
    php81-ftp  \
    php81-gd  \
    php81-gettext  \
    php81-gmp  \
    php81-iconv  \
    php81-imap  \
    php81-ldap  \
    php81-mbstring  \
    php81-mysqli  \
    php81-mysqlnd  \
    php81-odbc  \
    php81-opcache  \
    php81-openssl  \
    php81-pcntl  \
    php81-pdo  \
    php81-pdo_dblib  \
    php81-pdo_mysql  \
    php81-pdo_odbc  \
    php81-pdo_pgsql  \
    php81-pdo_sqlite  \
    php81-pear  \
    php81-pecl-apcu \
    php81-pecl-ast \
    php81-pecl-event \
    php81-pecl-igbinary \
    php81-pecl-imagick \
    php81-pecl-lzf \
    php81-pecl-maxminddb \
    php81-pecl-memcache \
    php81-pecl-memcached \
    php81-pecl-msgpack \
    php81-pecl-redis \
    php81-pecl-uploadprogress \
    php81-pecl-uuid \
    php81-pecl-xdebug \
    php81-pecl-xhprof \
    php81-pecl-yaml \
    php81-pgsql  \
    php81-phar  \
    php81-posix  \
    php81-pspell  \
    php81-session  \
    php81-shmop  \
    php81-simplexml  \
    php81-snmp  \
    php81-soap  \
    php81-sockets  \
    php81-sodium  \
    php81-sqlite3  \
    php81-tidy  \
    php81-tokenizer  \
    php81-xml  \
    php81-xmlreader  \
    php81-xmlwriter  \
    php81-xsl  \
    php81-zip  \
    php81-cli

RUN link /usr/bin/php81 /usr/bin/php

COPY ./docker/supervisord.conf /etc/supervisord.conf
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/app.conf /etc/nginx/sites-enabled/app.conf
COPY ./docker/run /usr/bin/run-app

WORKDIR /app

COPY . .

RUN chmod 777 /usr/bin/run-app && \
    chmod 777 -R bootstrap/cache && \
    chmod 777 -R storage

RUN composer install --no-ansi --no-dev --no-interaction --optimize-autoloader && \
    composer run post-root-package-install --no-ansi

EXPOSE 80

VOLUME ["/storage"]




# ENV APP_ENV production
# ENV APP_URL http://localhost
# ENV DB_CONNECTION
# ENV DB_HOST
# ENV DB_DATABASE
# ENV DB_USERNAME
# ENV DB_PASSWORD
# ENV REDIS_HOST
# ENV BROADCAST_DRIVER
# ENV CACHE_DRIVER
# ENV FILESYSTEM_DISK
# ENV QUEUE_CONNECTION
# ENV SESSION_DRIVER

CMD /usr/bin/run-app
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
