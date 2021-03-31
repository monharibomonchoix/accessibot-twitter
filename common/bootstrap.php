<?php
# Needed for initial configuration
# bootstrap.php

require_once (__DIR__ . "/../conf/conf.php");
require_once (__DIR__ . "/../vendor/autoload.php");

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$entitiesPath = [
    __DIR__ . "/Entity"
];

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPath,
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);
$entityManager = EntityManager::create(Conf::GetConnection(), $config);

return $entityManager;

