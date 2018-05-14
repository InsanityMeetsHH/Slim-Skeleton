<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

$generalSettings = include 'config/settings.php';
$additionalSettings = [];

if (is_readable('config/additional-settings.php')) {
    $additionalSettings = require 'config/additional-settings.php';
}
$settings = array_replace_recursive($generalSettings, $additionalSettings);
$settings = $settings['settings']['doctrine'];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);