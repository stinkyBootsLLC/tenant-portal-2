# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY ./app /var/www/html

# Install any needed dependencies
RUN apt-get update && \
    apt-get install -y git sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo_mysql pdo_sqlite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache when the container launches
CMD ["apache2-foreground"]
