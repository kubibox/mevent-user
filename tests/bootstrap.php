<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR, '.env.test');
$dotenv->load();

define('SRC_DIR', dirname(__DIR__) . '/src/');
