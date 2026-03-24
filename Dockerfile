FROM php:8.0-fpm-alpine

# 安装 PHP 扩展和 Nginx
RUN apk add --no-cache \
        nginx \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        icu-dev \
        oniguruma-dev \
        curl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mysqli \
        pdo_mysql \
        mbstring \
        curl \
        zip \
        opcache \
        fileinfo \
        bcmath \
    && rm -rf /var/cache/apk/*

# Nginx 配置
COPY deploy/nginx.conf /etc/nginx/http.d/default.conf

# PHP 配置
RUN { \
        echo 'display_errors = Off'; \
        echo 'memory_limit = 128M'; \
        echo 'post_max_size = 50M'; \
        echo 'upload_max_filesize = 50M'; \
        echo 'max_execution_time = 300'; \
        echo 'date.timezone = Asia/Shanghai'; \
        echo 'opcache.enable = 1'; \
        echo 'opcache.memory_consumption = 64'; \
    } > /usr/local/etc/php/conf.d/epay.ini

# 复制源码
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/runtime \
    && chmod -R 777 /var/www/html/runtime \
    && chmod -R 777 /var/www/html/config.php

# 启动脚本
COPY deploy/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
