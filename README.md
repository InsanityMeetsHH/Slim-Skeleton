# Slim 3 Skeleton Fork - InsanityMeetsHH

[**Demo page**](http://slim3.insanitymeetshh.net)

## Included
* [Slim 3.x](https://www.slimframework.com)
* [Slim Twig View 2.x](https://github.com/slimphp/Twig-View)
* [Slim CSRF 0.x](https://github.com/slimphp/Slim-Csrf)
* [Slim Flash 0.x](https://github.com/slimphp/Slim-Flash)
* [Monolog 1.x](https://seldaek.github.io/monolog/)
* [Doctrine ORM 2.x](https://packagist.org/packages/doctrine/orm)
* [Geggleto ACL 1.x](https://github.com/geggleto/geggleto-acl)
* [Google Authenticator](https://github.com/PHPGangsta/GoogleAuthenticator)

## Required
* PHP => 5.5
* Database like MySQL

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

## Setup database and config\additional-settings.php 
Rename `config\additional-settings.dist` to `config\additional-settings.php`.
(`config\additional-settings.php` is useful for working with git and your local environment is different to live or to your team mates)

Change `public_path` if you run the project in a sub directory.

If you want to use **_not_** MySQL and/or your server is **_not_** 127.0.0.1 then you have to add [driver](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L51) and/or [host](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L52) in [additional-settings.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist#L6)

Change database conditions in `config\additional-settings.php` (without `dbname`).
```bash
$ php doctrine dbal:run-sql "CREATE DATABASE slim3_database"
```

Add database name to `dbname` in `config\additional-settings.php` and run following command.
```bash
$ php doctrine orm:schema-tool:update --force
```
Now you've created the database tables named [user](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Entity/User.php) and [role](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Entity/Role.php).

If you want to fill the table with some roles and one user
```bash
$ php doctrine dbal:import sql/all-records.sql
```

## How to create further localisations
* Duplicate one existing file in folder `locale/` (e.g. copy `locale/de-DE.php` to `locale/fr-FR.php`)
* Change route prefix from `/de/` to `/fr/` in `locale/fr-FR.php`
* You can also define paths like `/fr-be/` (`locale/fr-BE.php`) for example
* If you want to show language in langswitch [config/settings.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L34)
* Add case for `fr/` in [src/localisation.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/localisation.php#L18)

## ACL settings
With [Geggleto ACL](https://github.com/geggleto/geggleto-acl), routes are protected by role the current user has. By default every new route is not accessable until you give the route roles.
Routes are defined in the route files (e.g. [routes-de-DE.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes-de-DE.php)).
Any other resource is defined in [settings.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L61).
Inside the Twig templates you can use ACL functions [has_role](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/partials/navigation.html.twig#L5) and [is_allowed](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/page/index.html.twig#L17).
Inside controllers you can also use this ACL functions and [many more](https://github.com/geggleto/geggleto-acl/blob/master/src/AclRepository.php) (e.g. [is_allowed](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/UserController.php#L23)).

## Troubleshooting
In some cases you'll get the error message "Internal Server Error".

If this happened, go to public/.htaccess and enable `RewriteBase /`.

If project is in sub directory than `RewriteBase /project/public/`.

## Sources
* [Slim 3 and Doctrine 2 Website](http://blog.sub85.com/slim-3-with-doctrine-2.html)
* [Slim 3 and Doctrine 2 Github](https://github.com/matthewfedak/slim-3-doctrine-2)
* [Slim Framework](https://www.slimframework.com/)
* [Twig](https://twig.symfony.com/)
* [Doctrine](https://www.doctrine-project.org/)

## Recommended
* [Adminer DB-GUI](https://www.adminer.org/)
* [Locale codes](https://www.science.co.il/language/Locale-codes.php)
