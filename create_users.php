#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/src/Command/CreateUserCommand.php';

use Symfony\Component\Console\Application;
use App\Command;

$application = new Application();
$application->add(new App\Command\CreateUserCommand());
$application->run();
