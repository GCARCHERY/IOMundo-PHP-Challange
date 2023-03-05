<?php

require __DIR__ . "/../../eloquent/bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

try {
    Capsule::schema()->create('users', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email');
        $table->longText('user_image')->nullable();
    });
    echo "DB Connection Succes! Migrating...";
} catch (Exception $e) {
    echo "DB Connection failed!";
}
