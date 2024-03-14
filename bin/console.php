#!/usr/bin/env php
<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

set_time_limit(0);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$commands = require __DIR__ . '/../app/commands.php';

$input = new ArgvInput();
$application = new Application();

foreach ($commands as $command) {
    $application->add($command);
}

$application->run($input);
