<?php
// This is the gate where the browser accesss public folder(The only accessible folder in laravel)

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Used to measure performance, from when the script starts running.
define('LARAVEL_START', microtime(true));

// Check if the application is in maintenance mode.. (if yes, will show "Website is under maintenance")
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Activate the Composer autoloader, it's all what i installed via composer.. (Pack all libraries so they are ready to use)
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel (prepare some important service like DB, Route, etc.. it's like activating machine)
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Catch the request from browser
$app->handleRequest(Request::capture());
