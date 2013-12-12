<?php

namespace WheelOfScouting\Services\Validation;

/**
 * Base Validation
 *
 * @package WheelOfScouting/Services/Validation/ValidationInterface
 */
interface ValidationInterface {
	
	/**
	 * Passes
	 * 
	 * @return boolean
	 */	
	public function passes();
	
	/**
	 * Fails
	 * 
	 * @return boolean
	 */
	public function fails();

}