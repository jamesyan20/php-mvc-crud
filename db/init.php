<?php

/*
 * Init the database in ORM
 */
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
   "driver" => "mysql",
   "host" =>"127.0.0.1",
   "database" => "teste",
   "username" => "root",
   "password" => "1234"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();


