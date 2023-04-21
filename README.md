# tenant-portal-2

SQLite Version

## Troubleshooting Notes:

- 4/21/2023: with current docker-compose.yml file, the application will display correctly. 

Note about yml file: this line is saying, use the files from the CURRENT DIRECTORY app folder, and simulate them into the container /var/www/html. 

```
volumes:
  - "./app:/var/www/html"

```
This means YOU MUST have these files locally.

Another issue happening, is that I cannot log into the app with the CORRECT credentials.  I think there is a problem with permissions.  NOT BEING ABLE TO READ OR WRITE to the SQLite3 DB file.



## Getting started




## Authors and acknowledgment
Show your appreciation to those who have contributed to the project.

## License
For open source projects, say how it is licensed.

## Project status
If you have run out of energy or time for your project, put a note at the top of the README saying that development has slowed down or stopped completely. Someone may choose to fork your project or volunteer to step in as a maintainer or owner, allowing your project to keep going. You can also make an explicit request for maintainers.
