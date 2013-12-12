<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

Illuminate\Support\ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/lib',
	app_path().'/lib/WheelOfFortune',
	app_path().'/lib/WheelOfFortune/Objects',
	app_path().'/lib/WheelOfFortune/Objects/Category',
	app_path().'/lib/WheelOfFortune/Objects/Puzzle',
	app_path().'/lib/WheelOfFortune/Services',
	app_path().'/lib/WheelOfFortune/Services/Debug',
	app_path().'/lib/WheelOfFortune/Services/Validation',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Illuminate\Support\Facades\Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

Illuminate\Support\Facades\App::error(function(Exception $exception, $code)
{
	Illuminate\Support\Facades\Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

Illuminate\Support\Facades\App::down(function()
{
	return Illuminate\Support\Facades\Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Require the Extenders File
|--------------------------------------------------------------------------
|
| Next we will load the extenders file for the application. This gives us
| a nice separate location to store our route and extension point
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/extenders.php';

/*
|--------------------------------------------------------------------------
| Require the Listeners File
|--------------------------------------------------------------------------
|
| Next we will load the event listeners file for the application. This gives us
| a nice separate location to store our route and event listener
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/listeners.php';

/*
|--------------------------------------------------------------------------
| Require the Macros File
|--------------------------------------------------------------------------
|
| Next we will load the macros file for the application. This gives us
| a nice separate location to store our route and HTML macro
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/macros.php';