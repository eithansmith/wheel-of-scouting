<?php

namespace WheelOfScouting\Services\Messages;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;

/**
 * Object MessagesServiceProvider
 *
 * @package WheelOfScouting/Services/Messages/MessagesServiceProvider
 */
class MessagesServiceProvider extends ServiceProvider {
	
	/**
	 * Register the binding
	 * Bind interfaces to the respective repositories
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;
		
		$this->app->bind('Messages', function()
		{
			return new MessageBag();
		});
	}
	
}