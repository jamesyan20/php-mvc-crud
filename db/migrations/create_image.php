<?php

require '../../vendor/autoload.php';
require "../init.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('image', function ($table) {
    $table->increments('id');
	$table->integer('product_id')->unsigned();
	$table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
		//->onCascade('delete');
    $table->string('uri');
    $table->timestamps();
});
