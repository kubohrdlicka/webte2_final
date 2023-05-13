FROM php:8.2-fpm

# Copy composer.lock and composer.json into the working directory
# COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    zip \
    vim \
    git \
    curl 

# Install extensions for php
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory


# Assign permissions of the working directory to the www-data user

# USER www-data
COPY . ./
RUN chown -R www-data:www-data ./

RUN composer install
RUN php artisan key:generate


# TODO php ini, ktore chceme
# TODO maybe images

RUN apt install -y python3-pip
RUN pip3 install --upgrade pip
RUN pip3 install sympy
RUN pip3 install antlr4-python3-runtime==4.10


RUN chown -R www-data:www-data /var/www/html/storage 


# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD sleep 5 && php artisan migrate && php-fpm