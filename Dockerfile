# Dockerfile for Laravel 12 + PHP 8.2 + git-lfs (for Railway)
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        git \
        git-lfs \
        unzip \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        curl \
        libzip-dev \
        libssl-dev \
        nodejs \
        npm \
    && git lfs install

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Increase PHP memory limit to 1GB
RUN echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install Composer (copy from official composer image)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files into container
COPY . /var/www

# Pull Git LFS files (important for prmpt_classifier.rbx)
RUN git lfs pull \
    && ls -lh prmpt_classifier.rbx || true

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Install PHP & Node dependencies, then build frontend
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run build

# Expose port 8080 for Railway
EXPOSE 8080

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
