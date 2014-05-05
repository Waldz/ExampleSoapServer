Example of Soap Server application
=======================

Introduction
------------
This is a simple SOAP server application implemented with ZF2, to show code separation patterns.


Installation
------------

Using Composer (recommended)
----------------------------
Step 1. Download and install composer to your computer (read howto at https://getcomposer.org/doc/)
    curl -s https://getcomposer.org/installer | php --

Step 2. Or manually invoke `composer` using the shipped `composer.phar`:
    # The `self-update` directive is to download newest up-to-date `composer.phar`
    php composer.phar self-update
    # This install all application required libraries for first time
    php composer.phar install
    php composer.phar dump-autoload --optimize

Step 3. Copy every file with *.dist in directory /config/autoload/
And dont commit your own local stuff to PRODUCTION!!!
    doctrine.local.php.dist  ->  doctrine.local.php
    zenddevelopertools.local.php.dist  ->  zenddevelopertools.local.php
    ...
    ...

Step 4. Import DB data
    data/schema.sql


Virtual Host
------------
Step1. Notepad.exe press "Run as Administrator"
Step2. Create fake domain in file  C:\Windows\System32\drivers\etc\hosts
    127.0.0.1       examplesoap.localhost

Step3. Add virtual host and restart Web server C:/Users/Valdas/xampp/apache/conf/httpd.conf
    <VirtualHost *:80>
        ServerName examplesoap.localhost

        DocumentRoot "C:/Users/Valdas/workspace/ExampleSoapServer/public"
        <Directory "C:/Users/Valdas/workspace/ExampleSoapServer/public">
            Options Indexes FollowSymLinks Includes ExecCGI
            AllowOverride FileInfo
            Order allow,deny
            Allow from All
        </Directory>
    </VirtualHost>


Automated testing
------------
    cd module/WordSoapServer/test/ && phpunit --configuration phpunit.xml


Using Doctrine console
------------
Everyday jobs:
    # How to map entities to DB
    http://docs.doctrine-project.org/en/2.0.x/reference/association-mapping.html
    # Check if Entity objects are correct
    vendor\bin\doctrine-module.bat orm:validate-schema

    # Alter database by entities (all other times)
    # Windows:
    vendor\bin\doctrine-module.bat orm:schema-tool:update --dump-sql
    vendor\bin\doctrine-module.bat orm:schema-tool:update --force
    # UNIX:
    ./vendor/bin/doctrine-module orm:schema-tool:update --dump-sql
    ./vendor/bin/doctrine-module orm:schema-tool:update --force

PROD deployment
------------
Step1. Install project required libraries
    php composer.phar self-update
    php composer.phar update

Step2. Buildings paths of all classess makes project superfast :)
Step2.1 Build class map (for EACH Module):
    sudo su www-data
    php ./vendor/bin/classmap_generator.php -l ./module/YourModuleName

Step2.2 Build template map (for EACH Module):
    cd module/YourModuleName
    php ../../vendor/zendframework/zendframework/bin/templatemap_generator.php -w