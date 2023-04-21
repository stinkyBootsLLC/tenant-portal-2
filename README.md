# Tenant Portal 2

PHP (CRUD) web application to track maintenance issues for a property manager. The original MySQL version is now converted to a SQLite Version.

## Troubleshooting Notes:

Learning Docker.

Note about the compose yml file: this line is saying, use the files from the **CURRENT DIRECTORY** `app` folder in the containers `/var/www/html` directory. 

```
volumes:
  - "./app:/var/www/html"

```
This means YOU MUST have these files locally. **No image has been built yet**

- 4/21/2023: with current docker-compose.yml file, the application will display correctly, but I cannot log into the app with the CORRECT credentials.  I think there is a problem with permissions.  NOT BEING ABLE TO READ OR WRITE to the SQLite3 DB file.


## Getting started

1. from the root directory run `docker build -t tenant-portal-2-php .`


WIP

## Authors and acknowledgment
Show your appreciation to those who have contributed to the project.

## License
For open source projects, say how it is licensed.

## Project status

Troubleshooting and building a docker version
