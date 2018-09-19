# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [5.0.1]
### Added
- [Docker documentation](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/README.md#L108)
- [`Dockerfile`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/Dockerfile)
- [`docker-dump.sql`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/sql/docker-dump.sql)

### Changed
- [`docker-compose.yml`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/docker-compose.yml)
- [`CONTRIBUTING.md`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/CONTRIBUTING.md)

### Removed
- `default_domain` from `locale` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L32) and [`config/additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php#L23)
- `default_domain` from [`LanguageExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php#L79)

## [5.0.0] - 2018-08-17
### Added
- Localized website by domain (exampl.de / de.example.com)
- Localized website by session (exampl.com for every language)
- Suffix for each controller method with "Action"
- Twig extension [`LanguageExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php)
- Twig extension [`AclExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/AclExtension.php)
- Twig extension [`GeneralExtension`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php)
- Twig global variable [`flashMessages`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php#L23)
- Twig global variable [`settings`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php#L22)
- Twig global variable [`localeProcess`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/GeneralExtension.php#L24)
- Route file [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)
- Route file [`config/routes/en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/en-US.php)
- Route file [`config/routes/xx-XX.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/xx-XX.php)
- UTC time zone as default for this application
- HTML label in forms
- [Google reCAPTCHA package](https://github.com/google/recaptcha)
- Google reCAPTCHA settings to [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L19)
- [CSS](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/public/css/styles.css#L64) for Google reCAPTCHA widget
- Registration form
- Localized flash messages for registration form
- Documentation in README.md
- `{{ glc }}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig#L4)
- Website session script in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig#L33)
- `public/favicon.ico`
- `process`, `default_domain` and `generic_code` to `locale` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L32)
- Domains to `locale => active`
- `$settings` to [`src/Controller/BaseController.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/BaseController.php#L66)
- `debug` and `cache` to `renderer` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L12)

### Changed
- `{{ lk }}` is now `{{ lc }}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig#L2)
- `AppExtension::language()` is now [`LanguageExtension::locale()`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php#L127)
- `locale => autoDetect` is now `locale => auto_detect` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L34)
- `aclResources` is now `acl_resources` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php#L65)
- `{{ path_for('route-name' ~ lc) }}` is now `{{ path_for('route-name-' ~ lc) }}` (with dash after route-name)
- `BaseController::$aclRepository` is now [`BaseController::$acl`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/BaseController.php#L17)
- `AclRepositoryContainer::$aclRepository` is now [`AclRepositoryContainer::$acl`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Container/AclRepositoryContainer.php#L12)
- Web font from Lato to Roboto

### Removed
- `src/Twig/AppExtension.php` - replaced by [`src/Twig/LanguageExtension.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php) and [`src/Twig/AclExtension.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/AclExtension.php)
- `config/routes-de-DE.php` - replaced by [`config/routes/de-DE.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/de-DE.php)
- `config/routes-en-US.php` - replaced by [`config/routes/en-US.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/routes/en-US.php)
- `config/additional-settings.dist` - replaced by [`config/additional-settings.dist.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/additional-settings.dist.php)
- `src/MappedSuperclass/LowerCaseUniqueName.php`
- `{% set ns = '-label' %}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `tests/Functional/HomepageTest.php`
