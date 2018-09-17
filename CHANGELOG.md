# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [5.0.0]
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
- Google reCAPTCHA settings to [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- [CSS](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/public/css/styles.css#L64) for Google reCAPTCHA widget
- Registration form
- Localized flash messages for registration form
- Documentation in README.md
- `{{ glc }}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- Website session script in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `public/favicon.ico`
- `process`, `default_domain` and `generic_code` to `locale` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- Domains to `locale => active`
- `$settings` to [`src/Controller/BaseController.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Controller/BaseController.php)
- `debug` and `cache` to `renderer` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)

### Changed
- `{{ lk }}` is now `{{ lc }}` in [`templates/layouts/layout.html.twig`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/templates/layouts/layout.html.twig)
- `AppExtension::language()` is now [`LanguageExtension::locale()`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/src/Twig/LanguageExtension.php#L127)
- `locale => autoDetect` is now `locale => auto_detect` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
- `aclResources` is now `acl_resources` in [`config/settings.php`](https://github.com/InsanityMeetsHH/Slim-Skeleton/blob/master/config/settings.php)
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
