<?php

require '../../vendor/autoload.php';
require "../init.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('product', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('description');
    $table->integer('quantity');
	$table->bigInteger('price');
    $table->timestamps();
});
