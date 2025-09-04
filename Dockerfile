# Use official PHP 8.2 Apache image
FROM php:8.2-apache

# Copy site files
COPY site/ /var/www/html/

# Enable Apache mod_rewrite (optional, for future use)
RUN a2enmod rewrite

# Set permissions (for classroom/demo use only)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
