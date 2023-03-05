<?php

require "vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "database" => "iomundo",
    "username" => "root",
    "password" => "root1234"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();