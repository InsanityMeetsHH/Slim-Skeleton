# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [5.3.0]
### Added
- settings for user validation
- settings for active pages
- user validation function
- database model ([`db-model.png`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/db-model.png))
- database column comments
- construction partial
- CI for twig templates
- condition for reCAPTCHA in [`layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig), [`register.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/user/register.html.twig) and [`UserController.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/UserController.php)

### Changed
- [`Setup.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)
- [`additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php)
- [`settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- [`localisation.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/localisation.php) to use less code
- [`en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/locale/en-US.php)
- [`de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/locale/de-DE.php)
- [`composer.lock`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/composer.lock)
- [`styles.css`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/public/css/styles.css)
- [`UserController.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/UserController.php)
- [`dependencies.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/dependencies.php)
- [`routes.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/routes.php)
- [`GeneralExtension.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php)
- [`docker-compose.yml`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/docker-compose.yml)
- default database host `127.0.0.1` to `localhost`
- default database name `slim_database` to `slim_skeleton`

### Removed
- `user-add` route and replaced by `user-register-save`
- `new \mysqli` and replaced by `new \PDO` in [`Setup.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)

## [5.2.0] - 2019-01-27
### Added
- `nochso/html-compress-twig` dependency
- [`composer.lock`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/composer.lock)
- `lang` attribute to langswitch
- form input styling in `public/css/styles.css`
- `{% htmlcompress %}...{% endhtmlcompress %}` to [`layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `<header>`, `<main>` and `<footer>` html tag to [`layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)

### Changed
- [`.gitignore`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/.gitignore)
- [`deploy.sh`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/deploy.sh)
- [`README.md`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/README.md)
- CSS properties sorted alphabetically
- [`Setup.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)
- [`additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php)
- [`settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- [`localisation.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/localisation.php)

## [5.1.1] - 2018-11-05
### Added
- symfony/console constrain

### Changed
- [Setup.php](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php) for better readablity

### Fixed
- All sql files

## [5.1.0] - 2018-10-29
### Removed
- Own colored CLI logic and replaced by Symfony\Component\Console\Formatter\OutputFormatterStyle

## [5.0.9] - 2018-10-18
### Added
- Inactive PHP 5.5 image to [`Dockerfile`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/Dockerfile)

### Changed
- Definition of the `$currentRole` simplified in [`AclRepositoryContainer.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Container/AclRepositoryContainer.php)

## [5.0.8] - 2018-10-12
### Fixed
- Reset database [script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)

## [5.0.7] - 2018-10-11
### Added
- `hidden` in [`Base.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/MappedSuperclass/Base.php)
- Skip CLI colors on windows operating system

## [5.0.6] - 2018-10-11
### Added
- `cascade={"persist", "remove"}` to [`User::$recoveryCodes`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Entity/User.php)
- Continuous integration update

## [5.0.5] - 2018-10-09
### Changed
- [`README.md`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/README.md)
- Text of import database process in [Composer setup script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)

### Fixed
- `doctrine/orm` version at `php >= 5.5.0` in [`composer.json`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/composer.json)

## [5.0.4] - 2018-10-08
### Added
- Dynamic generated [`public_path`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- [Docker condition](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/UserController.php) to reCAPTCHA validation
- `remove-cache` [Composer script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/composer.json)

### Changed
- [`README.md`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/README.md)
- [`GeneralUtility::encryptPassword`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Utility/GeneralUtility.php) from `mcrypt_create_iv` to `random_bytes`
- Return of [`GeneralUtility::getUserIP`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Utility/GeneralUtility.php)

### Removed
- `public_path` from [`additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php)

### Fixed
- `public_path` setup in [Composer setup script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)

## [5.0.3] - 2018-10-02
### Fixed
- Typo in [Composer setup script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)
- ErrorException `mysqli::__construct(): (HY000/2002): No such file or directory` in [Composer setup script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)

## [5.0.2] - 2018-09-30
### Added
- [Composer callbacks](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/composer.json)
- [Composer setup script](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Composer/Setup.php)
- [Database port](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- [`scripts.js`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/public/js/scripts.js)

### Changed
- [Docker documentation](https://github.com/InsanityMeetsHH/Slim-Skeleton#installation-with-docker)
- `docker-dump.sql` is now [`db-dump.sql`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/sql/db-dump.sql)

### Removed
- `"start": "php -S localhost:8080 -t public",` from [`composer.json`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/composer.json) (use docker instead)

## [5.0.1] - 2018-09-23
### Added
- [Docker documentation](https://github.com/InsanityMeetsHH/Slim-Skeleton#installation-with-docker)
- [`Dockerfile`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/Dockerfile)
- [`docker-dump.sql`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/sql/docker-dump.sql)

### Changed
- [`docker-compose.yml`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/docker-compose.yml)
- [`CONTRIBUTING.md`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/CONTRIBUTING.md)

### Removed
- `default_domain` from `locale` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php) and [`config/additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php)
- `default_domain` from [`LanguageExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php)

## [5.0.0] - 2018-09-17
### Added
- Localized website by domain (exampl.de / de.example.com)
- Localized website by session (exampl.com for every language)
- Suffix for each controller method with "Action"
- Twig extension [`LanguageExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php)
- Twig extension [`AclExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/AclExtension.php)
- Twig extension [`GeneralExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php)
- Twig global variable [`flashMessages`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php)
- Twig global variable [`settings`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php)
- Twig global variable [`localeProcess`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php)
- Route file [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)
- Route file [`config/routes/en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/en-US.php)
- Route file [`config/routes/xx-XX.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/xx-XX.php)
- UTC time zone as default for this application
- HTML label in forms
- [Google reCAPTCHA package](https://github.com/google/recaptcha)
- Google reCAPTCHA settings to [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- [CSS](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/public/css/styles.css) for Google reCAPTCHA widget
- Registration form
- Localized flash messages for registration form
- Documentation in [`README.md`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/README.md)
- `{{ glc }}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- Website session script in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `public/favicon.ico`
- `process`, `default_domain` and `generic_code` to `locale` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- Domains to `locale => active`
- `$settings` to [`src/Controller/BaseController.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/BaseController.php)
- `debug` and `cache` to `renderer` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)

### Changed
- `{{ lk }}` is now `{{ lc }}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `AppExtension::language()` is now [`LanguageExtension::locale()`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php)
- `locale => autoDetect` is now `locale => auto_detect` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- `aclResources` is now `acl_resources` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- `{{ path_for('route-name' ~ lc) }}` is now `{{ path_for('route-name-' ~ lc) }}` (with dash after route-name)
- `BaseController::$aclRepository` is now [`BaseController::$acl`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/BaseController.php)
- `AclRepositoryContainer::$aclRepository` is now [`AclRepositoryContainer::$acl`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Container/AclRepositoryContainer.php)
- Web font from Lato to Roboto

### Removed
- `src/Twig/AppExtension.php` - replaced by [`src/Twig/LanguageExtension.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php) and [`src/Twig/AclExtension.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/AclExtension.php)
- `config/routes-de-DE.php` - replaced by [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)
- `config/routes-en-US.php` - replaced by [`config/routes/en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/en-US.php)
- `config/additional-settings.dist` - replaced by [`config/additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php)
- `src/MappedSuperclass/LowerCaseUniqueName.php`
- `{% set ns = '-label' %}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `tests/Functional/HomepageTest.php`
