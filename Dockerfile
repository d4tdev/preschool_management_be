FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    curl \
    wget \
    git \
    unzip \
    libmcrypt-dev \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nodejs \
    npm \
    redis-tools \
    ca-certificates \
    fonts-liberation \
    libasound2 \
    libatk-bridge2.0-0 \
    libatk1.0-0 \
    libc6 \
    libcairo2 \
    libcups2 \
    libdbus-1-3 \
    libexpat1 \
    libfontconfig1 \
    libgbm1 \
    libgcc1 \
    libglib2.0-0 \
    libgtk-3-0 \
    libnspr4 \
    libnss3 \
    libpango-1.0-0 \
    libpangocairo-1.0-0 \
    libstdc++6 \
    libx11-6 \
    libx11-xcb1 \
    libxcb1 \
    libxcomposite1 \
    libxcursor1 \
    libxdamage1 \
    libxext6 \
    libxfixes3 \
    libxi6 \
    libxrandr2 \
    libxrender1 \
    libxss1 \
    libxtst6 \
    lsb-release \
    wget \
    xdg-utils \
    curl gnupg -y \
    && rm -rf /var/lib/apt/lists/* \
    && update-ca-certificates \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN apt-get install -y default-mysql-client

COPY docker/etc/nginx/conf.d/* /etc/nginx/sites-available/
COPY docker/etc/supervisor/supervisord.conf /etc/supervisord.conf
COPY docker/etc/supervisor/conf.d/*.conf /etc/supervisor/conf.d/

RUN ln -s /etc/nginx/sites-available/api.sougo-kankyo.local /etc/nginx/sites-enabled/ \
    && ln -s /etc/nginx/sites-available/mailpit.sougo-kankyo.local /etc/nginx/sites-enabled/ \
    && ln -s /etc/nginx/sites-available/phpmyadmin.sougo-kankyo.local /etc/nginx/sites-enabled/

WORKDIR /var/www/html
COPY ./src .
RUN npm install

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh


RUN cd /var/www/html && composer install

# Expose cổng 80
EXPOSE 80

# Sử dụng entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
