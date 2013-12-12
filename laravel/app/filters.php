<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

Illuminate\Support\Facades\App::before(function($request)
{
	//
});


Illuminate\Support\Facades\App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Illuminate\Support\Facades\Route::filter('auth', function()
{
	if (Illuminate\Support\Facades\Auth::guest()) return Illuminate\Support\Facades\Redirect::guest('login');
});


Illuminate\Support\Facades\Route::filter('auth.basic', function()
{
	return Illuminate\Support\Facades\Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Illuminate\Support\Facades\Route::filter('guest', function()
{
	if (Illuminate\Support\Facades\Auth::check()) return Illuminate\Support\Facades\Redirect::to('dashboard');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Illuminate\Support\Facades\Route::filter('csrf', function()
{
	if (Illuminate\Support\Facades\Session::token() != Illuminate\Support\Facades\Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

/*
Illuminate\Support\Facades\App::after(function($request, $response)
{
	if (Illuminate\Support\Facades\Auth::check())
	{
		//Get the name of the cookie, where remember me expiration time is stored
		$cookieName = Illuminate\Support\Facades\Auth::getRecallerName();
		
		//Get the value of the cookie
		$cookieValue = Illuminate\Support\Facades\Cookie::get($cookieName); 
		
		//Set the time to expire (minutes)
		$expire = 1440;
		
		//change the expiration time
		return $response->withCookie(Illuminate\Support\Facades\Cookie::make($cookieName, $cookieValue, $expire)); 
	}
});
*/