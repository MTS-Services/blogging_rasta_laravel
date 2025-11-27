FROM php:8.3-fpm

# Add custom php.ini file
COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    supervisor \
    gnupg2 \
    ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 20 LTS
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel app source
COPY . .

# Create all necessary directories
RUN mkdir -p storage/framework/{views,sessions,cache} \
    && mkdir -p storage/logs \
    && mkdir -p storage/app/public \
    && mkdir -p bootstrap/cache \
    && mkdir -p /var/log/supervisor

# Install dependencies (before changing ownership for better Docker layer caching)
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# CRITICAL: Set ownership and permissions (do this AFTER all file operations)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Create log file with correct permissions
RUN touch storage/logs/laravel.log \
    && chown www-data:www-data storage/logs/laravel.log \
    && chmod 664 storage/logs/laravel.log

# Laravel Artisan commands
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Configure Nginx and Supervisor
RUN rm -f /etc/nginx/sites-enabled/default
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose HTTP port
EXPOSE 80

# Start all services
CMD ["/usr/bin/supervisord", "-n"]
