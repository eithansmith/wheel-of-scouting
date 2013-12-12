<?php

namespace App\Controllers;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\View;

/**
 * BaseController
 *
 * @package App/Controller/CoilTestSheetController
 */
class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	protected function sanitizeName($name)
	{
		return preg_replace("[^A-Za-z0-9]", "", $name);
	}

}