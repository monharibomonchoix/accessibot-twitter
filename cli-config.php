<?php
# Needed for initial configurtation
# cli-config.php

$entityManager = require_once (__DIR__ . '/common/bootstrap.php');

use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet($entityManager);