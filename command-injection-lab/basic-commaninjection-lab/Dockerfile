# Use the official PHP image
FROM php:8.2-apache

# Copy the PHP script to the Apache document root
COPY src/index.php /var/www/html/
COPY flag/flag.txt /flag.txt
# Expose port 80
EXPOSE 80

# Run the Apache server
CMD ["apache2-foreground"]
