<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'bootstrap/app.php';

Router::load(['routes/web.php'])->direct(Request::uri(),Request::method());

