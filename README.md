# Slim Framework 3 Skeleton + Twig + Doctrine + Localisation

[**Demo page**](http://slim3.insanitymeetshh.net)

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install.

```bash
$ composer create-project insanitymeetshh/slim-skeleton [my-app-name]
```

This will install Slim and all required dependencies. Requires PHP 5.5 or newer.

Go to your project directory for following steps.

```bash
$ cd [my-app-name]
```

## Change namespace "Vendor\Bundle" to your own in:
* composer.json
* src/dependencies.php
* src/routes.php
* src/Controller/PageController.php
* src/Entity/Demo.php
* src/Twig/Extension/TwigExtension.php

After changing namespace from "Vendor\Bundle":
```bash
$ composer dump-autoload
```

## Setup Database and additional-settings.php 
Rename additional-settings.dist to additional-settings.php.
(additional-settings.php is useful for working with git and your local environment is different to live or to your team mates)

Change "public_path" if you run the project in a sub directory.

Change Database conditions in src\additional-settings.php (without "dbname").
```bash
$ php doctrine dbal:run-sql "CREATE DATABASE slim3_database"
```

Add database name to "dbname" in src\additional-settings.php and run following command.
```bash
$ php doctrine orm:schema-tool:update --force
```
Now you've created the database table "demo".

## How to create further localisations
* Duplicate one existing file in folder "locale" (e.g. copy de-DE.php to fr-FR.php)
* Change route prefix from "/de/" to "/fr/" in locale/fr-FR.php
* You can also define paths like "/fr-be/" (fr-BE.php) for example
* If you want to show language in langswitch src/settings.php -> ['locale']['active']
* Add case for "fr/" in src/localisation.php

## Troubleshooting
In some cases you'll get the error message "Internal Server Error".

If this happened, go to public/.htaccess and enable `RewriteBase /`.

If project is in sub directory than `RewriteBase /project/public/`.

## Sources
* [Slim 3 and Doctrine 2 Website](http://blog.sub85.com/slim-3-with-doctrine-2.html)
* [Slim 3 and Doctrine 2 Github](https://github.com/matthewfedak/slim-3-doctrine-2)
* [Slim Framework](https://www.slimframework.com/)
* [Twig](https://twig.symfony.com/)
* [Doctrine](http://docs.doctrine-project.org/en/latest/)

## Recommended
* [Adminer DB-GUI](https://www.adminer.org/)
* [Locale codes](https://msdn.microsoft.com/en-us/library/ee825488.aspx)
