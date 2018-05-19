<?php
$app->add(\App\Container\AclRepositoryContainer::setup());
$app->add($container->get('csrf'));