<?php

/*
|--------------------------------------------------------------------------
| Extend Authentication with Custom Driver
|--------------------------------------------------------------------------
|
| Uses custom User Prodiver, Interface, and Guard from Precoat Library
|
*/

/*
Illuminate\Support\Facades\Auth::extend('custom', function() {	
	$provider = new Precoat\Services\Authentication\CustomUserProvider(Illuminate\Support\Facades\App::make('AS400UserInterface'));
	
	return new Precoat\Services\Authentication\CustomGuard($provider, Illuminate\Support\Facades\App::make('session.store'));
});
*/