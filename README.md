BrokenOpenApp - a server for Android Crash Reporting library ACRA
=================================================================

A server to collect crash data of your android applications

For more see http://www.brokenopenapp.org/

## Requires

For normal use:

  *  PHP 5.4+
  *  Postgresql Database
  *  A cron job

If you want ProGuard support:

  *  Java
  *  Area of disk to store files on
  *  ProGuard library from Android SDK

## Installation

  * Get App Code from Github
  * Give permissions 777 to directories app/logs and app/cache
  * Run `composer install` to install the libraries
  * Copy the `app/config/parameters.yml.dist` file to `app/config/parameters.yml`
  * Edit `app/config/parameters.yml` to enter the connection details to your database server and the email addresses for notifications
  * Run the php commands to setup the project:


    // Set up DB
    php app/console doctrine:migrations:migrate --env=prod

    // Prepare the CSS and JS
    php app/console assets:install --env=prod --no-debug
    php app/console assetic:dump --env=prod --no-debug

  * set up the cron task

   php app/console brokenopenappcore:process-incoming-crashes --env=prod

## Installation of ProGuard

  * Give permissions 777 to directory uploads/proguardmappings
  * Edit `app/config/parameters.yml` to add

    jmb_technology_brokenopenapp_core.java_location: /usr/bin/java
    jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location: /var/www/acra-server/retrace.jar

Note as well as retrace.jar, you also need proguard.jar. This should be put in the same directory.

To test your install, you can run

    php app/console brokenopenappcore:test-proguard-library-install --env=prod


## Upgrade

  * Get latest app code from Github
  * Run `composer install` to install the latest libraries
  * Run

    php app/console cache:clear --env=prod
    php app/console doctrine:migrations:migrate --env=prod
    php app/console assets:install --env=prod --no-debug
    php app/console assetic:dump --env=prod --no-debug


## Open Source!

Under the Apache License.



