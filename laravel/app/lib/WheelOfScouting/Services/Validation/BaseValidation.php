<?php

namespace WheelOfScouting\Services\Validation;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use WheelOfScouting\Services\Debug\CustomDebug as Debug;

/**
 * Base Validation
 *
 * @package WheelOfScouting/Services/Validation/BaseValidation
 */
class BaseValidation {
	
	/**
	 * Constructor
	 * 
	 * @param mixed $input uses input::all if not set
	 */
	public function __construct($input = NULL)
	{
		$this->input = $input ? $input : Input::all();
	}
	
	/**
	 * 
	 * @var array
	 */
	protected $input;
	
	/**
	 * 
	 * @var MessageBag
	 */
	protected $messages;
	
	/**
	 * Passes
	 * 
	 * @return boolean
	 */	
	public function passes()
	{
		$validation = Validator::make($this->input, static::$rules);
	
		if($validation->passes())
			return true;
		 
		$this->messages = $validation->messages();
		//Debug::varDump($this->messages);
		
		Event::fire('message.send.warning', array($this->messages, 'Validation error:'));
		
		return false;
	}
	
	/**
	 * Fails
	 * 
	 * @return boolean
	 */
	public function fails()
	{
		return ! $this->passes();
	}
	
	/**
	 * Get Messages
	 * 
	 * @return \Illuminate\Support\MessageBag
	 */
	public function getMessages()
	{
		return $this->messages;
	}
		
}