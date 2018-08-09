<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$dir = dirname(dirname(__FILE__));
require_once "$dir/core/Err.php";
require_once "$dir/core/Router.php";
require_once "$dir/app/config/app.php";
$router = new Router();
$router->dispatch();
