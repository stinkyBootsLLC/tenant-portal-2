# Tenant Portal 2

PHP (CRUD) web application to track maintenance issues for a property manager. The original MySQL version is now converted to a SQLite Version.

This is a simple Create, Read, Update, and Delete (CRUD) web application. The purpose of this application, is to track maintenance issues for a property manager. Tenants can register to this application and report simple maintenance issues, up to the property manager.There is a login form for a tenant and a login form for a maintainer (manager). Once the maintainer logs in, they will be able to see all the issues reported by their Tenants. Issues are categorized in three categories, open, pending and closed. Built in 2018 for school project.

> :warning: This application is intended for academic purpose only and should not be used in a live production enviroment. See [Issues](issues.md)

## Software Architecture

- PHP 7.4
- Apache HTTP Server (latest)
- DB: SQLite3 

## Functional Features

### Registration Form

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

## Non Functional Features

### Security Controls

- Proper Password Strength Controls - Passwords for users must be 1 lower case, 1 upper case letter, 1 number and 1 special character and at least 8 characters in length
- [Validating and Sanitizing HTML](https://owasp.org/www-project-proactive-controls/v3/en/c5-validate-inputs) - Sanatizes input: Following character will not enter the db `':', '-', '/', '*','=','?'`
  - All input will be filtered by PHP `htmlspecialchars()` to convert special characters to HTML entities
- Passwords are stored in a Secure Fashion - 'sha256'
- Proper incorrect credentials error handling - _Login e-mail or Password is invalid_ [OWASP Authentication](https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html#authentication-and-error-messages)
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
**UPDATE:** This step is no loger required -> From the root directory run `docker build -t tenant-portal-2-php .` 

1. From the root directory run `docker compose up -d` or `docker-compose up -d`

<!--
4. Port into the running container `docker exec -it tenant-portal-2-apache-php-1 bash` 
   - Change ownership to the apache server `chown -R www-data:www-data /var/www/html` # this is apache on ubuntu
   - Check that the changes have taken place `ls -al`
   - Check that the db directory has changed `-rwxr-xr-x. 1 www-data www-data 36864 Apr 22 15:03 Tenants.sqlite`

5. Exit the running container `exit`

6. Shutdown the container `docker compose down` or `docker-compose down`

7. Restart the container `docker compose up -d` or `docker-compose up -d`
-->

2. Navigate to site URL. For example, if running locally then `http://localhost:3010` or remote `http://my-site:3010` 

3. Login prompt should now be displayed [see demo example](https://stinky-boots.online/TenantPortal2/)

4. Select tenant and login in as the default tenant `tenant@mail.com` pass=`1234`

5. Enter Random User Security Question Validation = `'answer'`

6. From the Tenant Dashboard report an issue, or view issues. (there is some dummy data included)

- Note: If you receive the following error.

> Warning: SQLite3Stmt::execute(): Unable to execute statement: attempt to write a readonly database in /var/www/html/tenants/includes/tenantFunctions.php on line 187 Error: contact admin -- ec-69

Then there is a problem with permission in the db directory

7. Shutdown the container `docker compose down` or `docker-compose down`

Persistent data will be available on the host `/var/lib/docker/volumes/tenant-db/Tenants.sqlite`

After the container is up and running, unless you plan on modifying the source code, you are free to remove all of these files. If you modify the source code, you will have to rebuild the image to see the changes. Recommend keeping `docker-compose.yml` for spinning up the container.

## Application Default Credentials

**Tenant:** tenant@mail.com  
**Pass:** "1234"

**Maintainer:** maint@mail.com  
**Pass:** "1234"

## License

> THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


## Project status

I will no longer be working on this project.
