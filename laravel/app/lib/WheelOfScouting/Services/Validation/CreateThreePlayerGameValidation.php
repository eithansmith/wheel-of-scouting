<?php

namespace WheelOfScouting\Services\Validation;

/**
 * Login Validation
 *
 * @package WheelOfScouting/Services/Validation/CreateThreePlayerGameValidation
 */
Class CreateThreePlayerGameValidation extends BaseValidation implements ValidationInterface {
	
	/**
	 * @var array
	 */
	public static $rules = array(
    	'player-one'  => 'required|max:20',
    	'player-two' => 'required|max:20',
		'player-three' => 'required|max:20',
	);

}