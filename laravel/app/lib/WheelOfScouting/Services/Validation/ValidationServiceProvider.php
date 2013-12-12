<?php

namespace WheelOfScouting\Services\Validation;

use WheelOfScouting\Services\Validation\CreateTwoPlayerValidation;
use WheelOfScouting\Services\Validation\CreateThreePlayerValidation;
use WheelOfScouting\Services\Validation\PuzzleValidation;
use Illuminate\Support\ServiceProvider;

/**
 * Validation ServiceProvider
 *
 * @package Precoat/Services/Validators/ValidatorServiceProvider
 */
class ValidationServiceProvider extends ServiceProvider {
	
	/**
	 * Register the binding
	 * Bind interfaces to the respective repositories
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;
			
		$this->app->bind('CreateTwoPlayerGameValidation', function()
		{
			return new CreateTwoPlayerGameValidation();
		});
		
		$this->app->bind('CreateThreePlayerGameValidation', function()
		{
			return new CreateThreePlayerGameValidation();
		});
		
		$this->app->bind('PuzzleValidation', function()
		{
			return new PuzzleValidation();
		});
	}
	
}