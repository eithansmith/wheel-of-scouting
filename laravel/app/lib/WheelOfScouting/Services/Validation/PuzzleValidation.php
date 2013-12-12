<?php

namespace WheelOfScouting\Services\Validation;

/**
 * Login Validation
 *
 * @package WheelOfScouting/Services/Validation/PuzzleValidation
 */
Class PuzzleValidation extends BaseValidation implements ValidationInterface {
	
	/**
	 * @var array
	 */
	public static $rules = array(
		'answer'  => 'required|max:100',
    	'category' => 'required',
		'difficulty' => 'required',
	);

}