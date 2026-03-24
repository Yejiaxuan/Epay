#!/bin/sh

# 安装完成后自动删除 install 目录
# 检测条件：install.lock 存在说明已完成安装
if [ -f /var/www/html/install/install.lock ] && [ -d /var/www/html/install ]; then
    echo "[security] Detected install.lock, removing install directory..."
    rm -rf /var/www/html/install
    echo "[security] Install directory removed."
fi

# 后台监控：安装向导完成后自动删除 install 目录
(
    while true; do
        sleep 10
        if [ -f /var/www/html/install/install.lock ] && [ -d /var/www/html/install ]; then
            echo "[security] Install completed, auto-removing install directory..."
            rm -rf /var/www/html/install
            echo "[security] Install directory removed."
            break
        fi
    done
) &

# 启动 PHP-FPM（后台）
php-fpm -D

# 启动 Nginx（前台，保持容器运行）
nginx -g 'daemon off;'
