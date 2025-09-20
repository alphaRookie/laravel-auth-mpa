<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/* custom command built-in breeze. call "php artisan inspire" to run */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/* made by me. call "php artisan greet ..(type name).." */
Artisan::command('greet {name}', function ($name) {
    $this->comment("yow, wassup {$name}, y'all good?");
})->purpose('Greet someone by their name');