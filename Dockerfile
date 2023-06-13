FROM php:8.1

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libwebp-dev \
    zlib1g-dev \
    libzip-dev \
    libxml2-dev \
    zip \
    unzip

# Clear package cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install project dependencies
RUN composer install

# Generate application key
RUN php artisan key:generate

# Expose port for Laravel serve
EXPOSE 8000