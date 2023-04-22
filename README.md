# Tenant Portal 2

PHP (CRUD) web application to track maintenance issues for a property manager. The original MySQL version is now converted to a SQLite Version.

## Software Architecture

- PHP 7.4
- Apache HTTP Server (latest)
- DB: SQLite3 

## Installation

1. Clone this project

## Deploy

### 1 - Standard Deployment

- Deploy on a LAMP stack

### 2 - Docker Deployment

Note about the compose yml file: this line below is saying, use the files from the **CURRENT DIRECTORY** `app` and **MIRROR** them inside the containers `/var/www/html` directory. 

```
volumes:
  - "./app:/var/www/html"
```

YOU MUST have these files locally. **They are NOT INCLUDED IN THE DOCKER IMAGE**

1. From the root directory run `docker build -t tenant-portal-2-php .`

2. On host machine `chmod 755 -R app/db`

3. From the root directory run `docker compose up -d` or `docker-compose up -d`

4. Port into the running container `docker exec -it tenant-portal-2-apache-php-1 bash` 
   - Change ownership to the apache server `chown -R www-data:www-data /var/www/html` # this is apache on ubuntu
   - Check that the changes have taken place `ls -al`
   - Check that the db directory has changed `-rwxr-xr-x. 1 www-data www-data 36864 Apr 22 15:03 Tenants.sqlite`

5. Exit the running container `exit`

6. Shutdown the container `docker compose down` or `docker-compose down`

7. Restart the container `docker compose up -d` or `docker-compose up -d`

8. Navigate to site URL. For example, if running locally then `http://localhost:3010` or remote `http://my-site:3010` 

9. Login prompt should now be displayed [see demo examaple](https://stinky-boots.online/TenantPortal2/)

10. Select tenant and login in as the default tenant `tenant@mail.com` pass=`1234`

11. Enter Random User Security Question Validation = `'answer'`

12. From the Tenant Dashboard report an issue, or view issues. (there is some dummy data include)

- Note: If you receive the following error.

> Warning: SQLite3Stmt::execute(): Unable to execute statement: attempt to write a readonly database in /var/www/html/tenants/includes/tenantFunctions.php on line 187 Error: contact admin -- ec-69

Then there is a problem with permission in the db directory (see step 4)

## License

For open source projects, say how it is licensed.

## Project status

Project still is Work in progress (WIP). My final goal is to have this a fully running image available on docker hub.
