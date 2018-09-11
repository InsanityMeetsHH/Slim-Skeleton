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
- Twig extension "LanguageExtension"
- Twig extension "AclExtension"
- Twig extension "GeneralExtension"
- Twig variable flashMessages global
- Twig variable settings global
- Route file `config/routes/de-DE.php`
- Route file `config/routes/en-US.php`
- Route file `config/routes/xx-XX.php`
- UTC time zone for created_at and updates_at
- HTML label in forms
- Google reCAPTCHA package
- Google reCAPTCHA settings to `config/settings.php`
- CSS for Google reCAPTCHA widget
- Registration form
- Localized flash messages for registration form
- Documentation in README.md
- `{{ glc }}` in `templates/layouts/layout.html.twig`
- Website session script in `templates/layouts/layout.html.twig`
- `public/favicon.ico`
- `process`, `use_domain`, `default_domain` and `generic_code` to `locale` in `config/settings.php`
- Domains to `locale => active`
- `$settings` to `src/Controller/BaseController.php`
- `debug` and `cache` to `renderer` in `config/settings.php`

### Changed
- `{{ lk }}` is now `{{ lc }}` in `templates/layouts/layout.html.twig`
- `AppExtension::language()` is now `LanguageExtension::locale()`
- `locale => autoDetect` is now `locale => auto_detect` in `config/settings.php`
- `aclResources` is now `acl_resources` in `config/settings.php`
- `{{ path_for('route-name' ~ lc) }}` is now `{{ path_for('route-name-' ~ lc) }}` (with dash after route-name)
- Web font from Lato to Roboto

### Removed
- Twig extension AppExtension - replaced by LanguageExtension and AclExtension
- Route file config/routes-de-DE.php
- Route file config/routes-en-US.php
- `{% set ns = '-label' %}` in `templates/layouts/layout.html.twig`
