# Tenant Portal 2

PHP (CRUD) web application to track maintenance issues for a property manager. The original MySQL version is now converted to a SQLite Version.

This is a simple Create, Read, Update, and Delete (CRUD) web application. The purpose of this application, is to track maintenance issues for a property manager. Tenants can register to this application and report simple maintenance issues, up to the property manager.There is a login form for a tenant and a login form for a maintainer (manager). Once the maintainer logs in, they will be able to see all the issues reported by their Tenants. Issues are categorized in three categories, open, pending and closed. Built in 2018 for school project.

> :warning: This application is intended for academic purpose only and should not be used in a live production enviroment.

## Software Architecture

- PHP 7.4
- Apache HTTP Server (latest)
- DB: SQLite3 

## Features

### Registration

- User self registration for access

### Tenant Reporting Dashboard

- Report maintenance issue
- View open and Pending issues
- View issue history

### Maintenance Viewing Dashboard

- Visualization of all ongoing tenant issues
- View recently added tenant maintenance issues
- View pending issues with scheduled repair dates
- View closed issues with completed repaired dates (history)
- Update issue status
- View all registered users

### Security

- Proper Password Strength Controls - Passwords for users must be 1 lower case, 1 upper case letter, 1 number and 1 special character and at least 8 characters in length
- Input validation for all form fields - Sanatizes input: Following character will not enter the db ':', '-', '/', '*','=','?'
- Passwords are stored in a Secure Fashion - 'sha256'
- Proper incorrect credentials error handling - Login e-mail or Password is invalid" [OWASP AUTHENTICACION](https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html#authentication-and-error-messages)
- Access Control - Session ID Generation and Verification
- SQL Injection Prevention - Use of Prepared Statements ([with Parameterized Queries](https://www.php.net/manual/en/sqlite3.prepare.php)) 

## Installation

1. Clone this project

## Deployment

### 1 - Standard Deployment

- Deploy on a LAMP stack

### 2 - Docker Deployment

<!-- 
Note about the compose yml file: this line below is saying, use the files from the **CURRENT DIRECTORY** `app` and **MIRROR** them inside the containers `/var/www/html` directory. 

```
volumes:
  - "./app:/var/www/html"
```
YOU MUST have these files locally. **They are NOT INCLUDED IN THE DOCKER IMAGE**

-->
1. From the root directory run `docker build -t tenant-portal-2-php .`

2. From the root directory run `docker compose up -d` or `docker-compose up -d`

<!--
4. Port into the running container `docker exec -it tenant-portal-2-apache-php-1 bash` 
   - Change ownership to the apache server `chown -R www-data:www-data /var/www/html` # this is apache on ubuntu
   - Check that the changes have taken place `ls -al`
   - Check that the db directory has changed `-rwxr-xr-x. 1 www-data www-data 36864 Apr 22 15:03 Tenants.sqlite`

5. Exit the running container `exit`

6. Shutdown the container `docker compose down` or `docker-compose down`

7. Restart the container `docker compose up -d` or `docker-compose up -d`
-->

3. Navigate to site URL. For example, if running locally then `http://localhost:3010` or remote `http://my-site:3010` 

4. Login prompt should now be displayed [see demo examaple](https://stinky-boots.online/TenantPortal2/)

5. Select tenant and login in as the default tenant `tenant@mail.com` pass=`1234`

6. Enter Random User Security Question Validation = `'answer'`

7. From the Tenant Dashboard report an issue, or view issues. (there is some dummy data include)

- Note: If you receive the following error.

> Warning: SQLite3Stmt::execute(): Unable to execute statement: attempt to write a readonly database in /var/www/html/tenants/includes/tenantFunctions.php on line 187 Error: contact admin -- ec-69

8. Shutdown the container `docker compose down` or `docker-compose down`

Then there is a problem with permission in the db directory

## Application Default Credentials

**Tenant:** tenant@mail.com  
**Pass:** "1234"

**Maintainer:** maint@mail.com  
**Pass:** "1234"

## License

For open source projects, say how it is licensed.

## Project status

Project still is Work in progress (WIP). My final goal is to have this a fully running image available on docker hub.
