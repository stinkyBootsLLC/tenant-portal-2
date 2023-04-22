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