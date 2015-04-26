acra-server
===========

A server to collect crash data of your android applications

## WORK IN PROGRESS - USE WITH PAIN - CHECK BACK IN A FEW MONTHS FOR MORE!

## Installation

The app can be installed on your server by installing the Symfony framework first and then this bundle (requires command line access to git, php and composer on your server)

This app is nothing more than a regular Symfony bundle and can be installed as such (I am no Symfony expert, feel free to give your feedback on that install procedure):

- Install the bundle from gitHub (git://github.com/marvinlabs/acra-server.git) on your server
- Give permissions 777 to directories app/logs and app/cache
- Run composer to install the Symfony framework
- Copy the `app/config/parameters.yml.dist` file to `app/config/parameters.yml`
- Edit `app/config/parameters.yml` to enter the connection details to your database server and the email addresses for notifications
- Run the php commands to setup the project:

    // If the DB is not created
    php app/console doctrine:database:create --env=prod 
    
    // Create the DB tables
    php app/console doctrine:schema:create --env=prod
    
    // Prepare the CSS and JS
    php app/console assets:install --env=prod --no-debug
    php app/console assetic:dump --env=prod --no-debug

- If all is fine, you should be able to access the app at http://www.yourdomain.com/dashboard
