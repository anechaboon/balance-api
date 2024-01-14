# Dockerfile

# เลือกภาพที่เป็น PHP 7.4-fpm
FROM php:7.4-fpm

# ติดตั้ง MySQL client และ dependencies สำหรับ Laravel
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \ 
    libxslt1-dev \
    openssh-server \
    openssh-client \
    rsync

RUN docker-php-ext-install pdo pdo_mysql
    
# ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

