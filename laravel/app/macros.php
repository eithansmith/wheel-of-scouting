<?php

namespace App;

use Illuminate\Support\Facades\HTML;

/*
|--------------------------------------------------------------------------
| HTML Macros
|--------------------------------------------------------------------------
|
| Here is where you can register all HTML macro helper functions
|
*/
HTML::macro('fieldError', function($field, $messages) {
	
	if (!$field || !$messages)
		return 'none';
	
	if ($messages->has($field))
		return 'form_field_error';
	else
		return 'none-but-i-checked';
});