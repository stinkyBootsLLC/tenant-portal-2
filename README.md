# Tenant Portal 2

PHP (CRUD) web application to track maintenance issues for a property manager. The original MySQL version is now converted to a SQLite Version.

https://www.sqlite.org/index.html

 php:7.4-apache

## Troubleshooting Log:

- 4/21/2023: with current docker-compose.yml file, the application will display correctly, but I cannot log into the app with the CORRECT credentials.  I think there is a problem with permissions.  NOT BEING ABLE TO READ OR WRITE to the SQLite3 DB file.

- 4/21/2023: this is killing everything in container `MYSQLI_ASSOC`

- 4/21/2023: In the contatiner I am unable to write to the db

> Warning: SQLite3Stmt::execute(): Unable to execute statement: attempt to write a readonly database in /var/www/html/tenants/includes/tenantFunctions.php on line 187
Error: contact admin -- ec-69

  Steps taken
  
  On host `chmod 755 -R db`

  In container `docker exec -it tenant-portal-2-apache-php-1 bash`

  `chown -R www-data:www-data /var/www/html` # this is apache on ubuntu

  OUTPUT `-rwxr-xr-x. 1 www-data www-data 36864 Apr 22 15:03 Tenants.sqlite`

  Seems to have fixed the issue, I am able to now write to db.  I checked both Tenant and Maintainer

## Software Architecture

- PHP 7.4
- Apache HTTP Server (latest)

## Installation

1. Clone this project

## Deploy

### Docker

Note about the compose yml file: this line is saying, use the files from the **CURRENT DIRECTORY** `app` and **MIRROR** them inside the containers `/var/www/html` directory. 

```yml
volumes:
  - "./app:/var/www/html"

```
This means YOU MUST have these files locally. **They are NOT INCLUDED IN THE IMAGE**

1. from the root directory run `docker build -t tenant-portal-2-php .`

2. from the root directory run `docker compose up -d` (_if using plugin_)
  - if using docker compose stand alone install then `docker-compose up -d`


## Authors and acknowledgment
Show your appreciation to those who have contributed to the project.

## License
For open source projects, say how it is licensed.

## Project status

Troubleshooting and building a docker version
