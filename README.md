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
* [Google reCAPTCHA](https://github.com/google/recaptcha)

## Required
* PHP => 5.5
* Database like MySQL

## Installation with [Composer](https://getcomposer.org/) (Recommended)

```bash
$ composer create-project insanitymeetshh/slim-skeleton [my-app-name]
```

This will install Slim and all required dependencies. Requires PHP 5.5 or newer.

Go to your project directory for following steps.

```bash
$ cd [my-app-name]
```

## Setup database and `config\additional-settings.php` (only if you don't use `composer create-project`)
Duplicate [`config\additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php) to `config\additional-settings.php`.
(`config\additional-settings.php` is useful for working with git and your local environment is different to live or to your team mates)

Change `public_path` if you run the project in a sub directory.

If you want to use **_not_** MySQL and/or your server is **_not_** 127.0.0.1 then you have to add [`driver`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L56) and/or [`host`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L57) in `config/additional-settings.php`

Change database conditions in `config\additional-settings.php` (without `dbname`).
```bash
$ php doctrine dbal:run-sql "CREATE DATABASE slim_database"
```

Add database name to `dbname` in `config\additional-settings.php` and run following command.
```bash
$ php doctrine orm:schema-tool:update --force
```
Now you've created the database tables named [user](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Entity/User.php) and [role](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Entity/Role.php).

The last step is to fill the table with some roles and one user
```bash
$ php doctrine dbal:import sql/all-records.sql
```

## How to create further localisations
* Duplicate one existing file in folder [`locale/`](https://github.com/InsanityMeetsHH/Slim-Skeleton/tree/master/locale) (e.g. copy `locale/de-DE.php` to `locale/fr-FR.php`)
* Change route prefix from `/de/` to `/fr/` in `locale/fr-FR.php`
* You can also define paths like `/fr-be/` (`locale/fr-BE.php`) for example
* If you want to show language in langswitch [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L38)
* Add case for `fr/` in [`src/localisation.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/localisation.php#L34)

## How to switch from example.com/de/ to de.example.com or example.de
* (EN is default language and DE is alternative language for this example)
* Got to `config\additional-settings.php` `locale`
* Set `'process' => \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_ENABLED,`
* Enter your domains in `active`
* Go to [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)
* Remove `/de` from every `route`
* Go to [`config/routes/xx-XX.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/xx-XX.php)
* Insert all routes where the config is equal in [`config/routes/en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/en-US.php) and [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)
* Remove these equal routes in [`config/routes/en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/en-US.php) and [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)

## How to use same url for all languages (like [youtube](https://www.youtube.com/) or [twitter](https://twitter.com/))
* (EN is default language and DE is alternative language for this example)
* Got to `config\additional-settings.php` `locale`
* Set `'process' => \App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED,`
* Set up all routes in [`config/routes/xx-XX.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/xx-XX.php)

## Path generation with Locale code and Generic locale code
* example.com/de/ = `'process' => \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED,`
* example.de = `'process' => \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_ENABLED,`
* example.com (de-DE session) = `'process' => \App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED,`

It depends on your configuration what will be returned.

|                     | example.com/de/ | example.de | example.com (de-DE session) |
|---------------------|-----------------|------------|-----------------------------|
| locale code         | de-DE           | de-DE      | xx-XX                       |
| generic locale code | de-DE           | xx-XX      | xx-XX                       |

|                     | Twig        | PHP                                   | Twig Example                            | PHP Example                                                                   |
|---------------------|-------------|---------------------------------------|-----------------------------------------|-------------------------------------------------------------------------------|
| locale code         | `{{ lc }}`  | `LanguageUtility::getLocale()`        | `{{ path_for('user-register-' ~ lc) }}` | `$this->router->pathFor('user-register-' . LanguageUtility::getLocale())`     |
| generic locale code | `{{ glc }}` | `LanguageUtility::getGenericLocale()` | `{{ path_for('user-login-' ~ glc) }}`   | `$this->router->pathFor('user-login-' . LanguageUtility::getGenericLocale())` |

## ACL settings
With [Geggleto ACL](https://github.com/geggleto/geggleto-acl), routes are protected by role the current user has. By default every new route is not accessable until you give the route roles.
Routes are defined in the route files (e.g. [config/routes/de-DE.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)).
Any other resource is defined in [settings.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L66).
Inside the Twig templates you can use ACL functions [has_role](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/partials/navigation.html.twig#L5) and [is_allowed](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/page/index.html.twig#L18).
Inside controllers you can also use this ACL functions and [many more](https://github.com/geggleto/geggleto-acl/blob/master/src/AclRepository.php) (e.g. [is_allowed](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/UserController.php#L24)).

## Installation with [Docker](https://www.docker.com/)
* Get skeleton via `git clone` or zip download
* `docker pull composer`
* `docker run --rm --env docker=true --interactive --tty --volume $PWD:/app composer update`
* `docker-compose build`
* `docker-compose up -d`
* `cp config\additional-settings.dist.php config\additional-settings.php`
* `docker inspect slim-db | grep IPAddress` set ip as Doctrine `host` in `config\additional-settings.php`
* Open [localhost:8080](http://localhost:8080) for website or [localhost:9999](http://localhost:9999) for database gui
* If you want to remove a container `docker rm [container-name] -f` e.g. `docker rm slim-db -f`
* If you want to remove a volume `docker volume rm [volume-name]` e.g. `docker volume rm imhh-slim_db_data` (first remove matching container)
* If you want to remove all container `docker rm $(docker ps -a -q) -f`
* If you want to remove all volumes `docker volume prune` (first remove all container)

## Troubleshooting
In some cases you'll get the error message "Internal Server Error".

If this happened, go to `public/.htaccess` and enable `RewriteBase /`.

If project is in sub directory then `RewriteBase /project/public/`.

## Sources
* [Slim 3 and Doctrine 2 Website](http://blog.sub85.com/slim-3-with-doctrine-2.html)
* [Slim 3 and Doctrine 2 Github](https://github.com/matthewfedak/slim-3-doctrine-2)
* [Slim Framework](https://www.slimframework.com/)
* [Twig](https://twig.symfony.com/)
* [Doctrine](https://www.doctrine-project.org/)

## Recommended
* [Adminer DB-GUI](https://www.adminer.org/)
* [Locale codes](https://www.science.co.il/language/Locale-codes.php)
