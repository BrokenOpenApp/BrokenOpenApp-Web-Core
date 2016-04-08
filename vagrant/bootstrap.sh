#!/usr/bin/env bash

echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen

locale-gen

sudo apt-get update
sudo apt-get install -y apache2 postgresql php5 php5-curl php5-pgsql git php5-intl libapache2-mod-php5  curl zip  phpunit openjdk-7-jre

echo "xdebug.max_nesting_level=1000" >> /etc/php5/apache2/conf.d/20-xdebug.ini

mkdir /home/vagrant/bin
cd /home/vagrant/bin
wget https://getcomposer.org/composer.phar

cd /vagrant
php /home/vagrant/bin/composer.phar  install

su --login -c "psql -c \"CREATE USER brokenopenapp WITH PASSWORD 'password';\"" postgres
su --login -c "psql -c \"CREATE DATABASE brokenopenapp WITH OWNER brokenopenapp ENCODING 'UTF8'  LC_COLLATE='en_GB.UTF-8' LC_CTYPE='en_GB.UTF-8'  TEMPLATE=template0 ;\"" postgres
su --login -c "psql -c \"CREATE DATABASE brokenopenapptest WITH OWNER brokenopenapp ENCODING 'UTF8'  LC_COLLATE='en_GB.UTF-8' LC_CTYPE='en_GB.UTF-8'  TEMPLATE=template0 ;\"" postgres

cp /vagrant/vagrant/apache.conf /etc/apache2/sites-enabled/000-default.conf
cp /vagrant/vagrant/config.php /vagrant/config.php
cp /vagrant/vagrant/parameters_test.yml /vagrant/app/config/parameters_test.yml
cp /vagrant/vagrant/parameters.yml /vagrant/app/config/parameters.yml
cp /vagrant/vagrant/app_dev.php /vagrant/web/app_dev.php

touch /vagrant/app/logs/prod.log
touch /vagrant/app/logs/dev.log
chown -R www-data:www-data /vagrant/app/logs/prod.log
chown -R www-data:www-data /vagrant/app/logs/dev.log

mkdir /vagrant/app/cache/dev/
mkdir /vagrant/app/cache/prod/

rm -r /vagrant/app/cache/prod/*
rm -r /vagrant/app/cache/dev/*

php /vagrant/app/console doctrine:migrations:migrate --no-interaction

chown -R www-data:www-data /vagrant/app/cache/prod/
chown -R www-data:www-data /vagrant/app/cache/dev/

php /vagrant/app/console  assetic:dump  --env=prod
php /vagrant/app/console  assetic:dump  --env=dev

a2enmod rewrite
a2enmod ssl
/etc/init.d/apache2 restart

cd /tmp
wget http://downloads.sourceforge.net/project/proguard/proguard/5.2/proguard5.2.1.zip
unzip proguard5.2.1.zip 
mv proguard5.2.1/lib/*.jar /home/vagrant/bin/
