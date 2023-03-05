<?php

require "vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as Capsule;

$env = parse_ini_file('.env');
$capsule = new Capsule;

$capsule->addConnection([
    "driver" => $env['DB_DRIVER'],
    "host" => $env['DB_HOST'],
    "database" => $env['DB_NAME'],
    "username" => $env['DB_USERNAME'],
    "password" => $env['DB_PASSWORD'],
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();