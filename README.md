Example of Soap Server application
=======================

Introduction
------------
This is a simple, skeleton application using the ZF2 MVC layer and module systems.


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


PROD deployment
------------
Step1. Install project required libraries
    php composer.phar self-update
    php composer.phar update

Step2. Buildings paths of all classess makes project superfast :)
# Build class map (for EACH Module):
    sudo su www-data
    php ./vendor/bin/classmap_generator.php -l ./module/YourModuleName

# Build template map (for EACH Module)::
    cd module/YourModuleName
    php ../../vendor/zendframework/zendframework/bin/templatemap_generator.php -w