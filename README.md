# Infotainment Database

This application was created as a part of master's thesis by Vojtěch Sillik.

Infotainment Database application is used to store infotainments' profiles with timings. The application is able to export profiles in E-EDID v1.4 binary files.

Several user roles (customer, operator, validator and administrator) are used for users. Each offers specific capabilities.

Laravel framework v11 is used for the application together with the Bootstrap CSS framework v5.3.

Docker images provided by Laravel Sail are available.

PHPStan with Larastan extension and Laravel Pint are used for code quality checks, PHPUnit is used for testing of EDID export functionality. Both of these are being automatically run on push in GitHub Actions.

## Application requirements

- PHP 8.2+ with extensions specified in the [Laravel documentation](https://laravel.com/docs/11.x/deployment)
- MySQL/MariaDB
- HTTP server (tested with Apache)
- SMTP server for sending email notifications

## How to run locally

You can use Laravel Sail for a local development environment to run the application in Docker containers.

You need to have Docker installed locally. If you are using Windows, using WSL2 (tested with Ubuntu) is required. The following commands are expected to be run in WSL2 or Linux.

Install the required requirements via Composer, you can also use the following command if you do not have Composer installed locally or do not have the required PHP version and extensions.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    composer install
```

You can use Laravel Sail (other commands are available in the [Laravel documentation](https://laravel.com/docs/11.x/sail)) to control (not only) the Docker containers via commands:

- `vendor/bin/sail up -d` to start the containers
- `vendor/bin/sail down` to stop and remove the containers
- `vendor/bin/sail down -v` to stop and remove the containers, including the data for MySQL database
- `vendor/bin/sail exec <container name> <command to execute>` to execute command inside container
- `vendor/bin/sail artisan <command>` to execute command via Laravel Artisan in `laravel.test` container

After installing dependencies via Composer and creating the `.env` file, you can start the containers via `vendor/bin/sail up -d`. Then you can install JS and CSS dependencies via command `vendor/bin/sail npm install`. Then you can build assets (via Vite) via command `vendor/bin/sail npm run build`, this command should be rerun after every change in the source CSS and JS files.

Before entering the application, the configuration must be finished first.  Run command `vendor/bin/sail artisan key:generate` to generate the application encryption key. Then you need to run command `vendor/bin/sail artisan migrate` to run database migrations, when there is a new database migration, this command should be rerun (for more information visit the [Laravel documentation](https://laravel.com/docs/11.x/migrations)). 

Now you are all set up to access the application at http://localhost, you can log in as administrator with email `admin@example.com` and password `SuperAdminPassword`.

Next time when you want to start the application, you can call the command `vendor/bin/sail up -d`, when you want to stop the application, you can run the command `vendor/bin/sail down`. 

## How to deploy the application

The following guide is written for deployment on [Wedos](https://wedos.cz) web hosting. Unfortunately, it does not provide access to command line, so Laravel Artisan cannot be run, thus database migrations cannot be performed on the server. Also, the hosting does not allow external connections to the database, thus the migrations must be first run locally, the database dumped and then imported into the hosting's database manually. This makes it impossible to use the full potential of migrations, thus any future changes of database schema in migrations must be transferred manually to the production database. 

Wedos hosting uses the Apache HTTP server, the application is configured to work on this specific web hosting, it might require some additional configuration for other deployment environments. Configuration example for Nginx HTTP server can be found in the [Laravel documentation](https://laravel.com/docs/11.x/deployment).

If deploying on to different deployment environment, some steps might not be necessary (like running migrations locally).

### Deployment Prerequisites

Before deploying to a web hosting, you need to have in your (Wedos) hosting administration:

- A created database
- A created email account (for sending notifications from the application)
- set HTTPS certificate up (optional)

### Deployment steps

The following steps were performed on a Windows operating system with Ubuntu (Linux) within WSL (Windows Subsystem for Linux). You need to have Docker installed locally. If you are using Windows, using WSL2 (tested with Ubuntu) is required. The following commands are expected to be run in WSL2 or Linux.

First, you need to clone the repository with the source code using Git, alternatively, you can download the source code from this repository in ZIP format. 

1. Install PHP dependencies (using Composer within a one-time Docker container) including development dependencies (this enables Laravel Sail for use) with the following command:

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/opt \
        -w /opt \
        laravelsail/php82-composer:latest \
        composer install
    ```

2. Copy the `.env.example` file as the `.env` configuration file, this file contains the default configuration for use with Laravel Sail locally.

3. Start Docker containers using Laravel Sail with the command `vendor/bin/sail up -d`.

4. Switch to the `laravel.test` container, which contains the necessary tools for further steps, using the command `vendor/bin/sail exec laravel.test bash`. Here, perform the following actions:

   1. Generate an application encryption key with the command `php artisan key:generate`.
   
   2. Install JavaScript dependencies with the command `npm install`.
   
   3. Generate the final CSS and JavaScript files with Vite with the command `npm run build`.
   
   4. Run migrations on the local database (in the `mysql` container) with the command `php artisan migrate`.
   
   5. Optimize application views with the command `php artisan view:cache`.
   
   6. Optimize routes for the application router with the command `php artisan route:cache`.
   
   7. Exit the `laravel.test` container with the command `exit`.

5. Export data from the local database using the `mysqldump` tool within the `mysql` container with the following command, which uses the default credentials to access this database: `vendor/bin/sail exec mysql sh -c 'mysqldump --user="sail" --password="password" laravel --no-tablespaces > /tmp/database_dump.sql'`.

6. Copy the exported data file from the `mysql` container to the working directory with the command `vendor/bin/sail cp mysql:/tmp/database_dump.sql ./database_dump.sql`.

7. Remove development dependencies for PHP (using Composer) with the command `vendor/bin/sail composer install --no-dev`, which uninstalls Laravel Sail as well.

8. Remove running containers with the command `docker compose down -v`, the `-v` switch also removes data in the MySQL database.

After completing these steps, the application is ready for deployment. First, you need to import the `database_dump.sql` file from steps 5 and 6 into the created database on Wedos hosting. This can be done using *phpMyAdmin* on Wedos hosting, where you first need to select a database, then choose the `Import` option, and upload this file.

Next, you need to modify the configuration in the `.env` file for the production environment. Each relevant configuration option in this file is commented. You need to set:

- Application name (`APP_NAME`, default can be kept)
- Application environment (`APP_ENV`) to the value `production`
- Application debug mode (`APP_DEBUG`) to the value `false`
- Application URL (`APP_URL`) - including the scheme `http://` or `https://`
- IEEE identifier for the vendor-specific data blocks (`APP_VENDOR_ID`)
- Individual components of color characteristics (starting with `APP_CHROMATICITY`)
- Default document version for the vendor-specific data block guide (`APP_VENDOR_GUIDE_DEFAULT_MAJOR` and `APP_VENDOR_GUIDE_DEFAULT_MINOR`)
- Database connection:
  - Host (`DB_HOST`)
  - Port (`DB_PORT`), the default port is working for Wedos hosting
  - Database name (`DB_DATABASE`)
  - Username (`DB_USERNAME`), the user with prefix `w` should be used when using Wedos hosting
  - User password (`DB_PASSWORD`)
- SMTP server connection:
  - Host (`MAIL_HOST`)
  - Port (`MAIL_PORT`), for Wedos use the port `587`
  - Username (`MAIL_USERNAME`), for Wedos it's the created e-mail address (including domain)
  - User password (`MAIL_PASSWORD`)
  - Communication encryption (`MAIL_ENCRYPTION`), for Wedos use `tls`
  - Displayed sender email (`MAIL_FROM_ADDRESS`)
  - Displayed sender name (`MAIL_FROM_NAME`)

Then you can upload the application to the hosting via FTP. For proper functionality, you need to upload (at least) the following directories and files to the directory `www / domains / <domain name>` (this directory is specific for Wedos):
- app
- bootstrap
- config
- database
- lang
- public
- resources
- routes
- storage
- vendor
- .env
- .htaccess
- artisan

After uploading the files, check the permissions for the directory `bootstrap / cache` and all subdirectories (including this directory) of `storage`, so the PHP process can write into these directories. The advised permission is `770` (read, write, and execute allowed for both the owner and the group).

Now you can log in to the application at the configured application URL address using the username `admin@example.com` and password `SuperAdminPassword`. It's recommended to change the default administrator password.
