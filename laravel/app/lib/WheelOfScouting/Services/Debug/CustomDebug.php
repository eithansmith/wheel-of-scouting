<?php

namespace WheelOfScouting\Services\Debug;

use Doctrine\Common\Util\Debug as DoctrineDebug;

class CustomDebug {
	
	/**
	 * DEFAULT - Always die() after debug output
	 *
	 * @var integer
	 */
	const DIE_ON = 0;
	
	/**
	 * Do not die() after debug output
	 *
	 * @var integer
	 */
	const DIE_OFF = 1;
	
	/**
	 * DEFAULT - Wrap <pre> tags around debug output
	 *
	 * @var integer
	 */
	const PREFORMATED_ON = 2;
	
	/**
	 * Do not wrap <pre> tags around debug output
	 *
	 * @var integer
	 */
	const PREFORMATED_OFF = 3;
	
	/**
	 * DEFAULT - Outside of App::env=dev debug is skipped
	 * Useful so that uncommented debug statements are not run in production 
	 *
	 * @var integer
	 */
	const DEV_ONLY_ON = 4;
	
	/**
	 * Alway run debug regardless of the App:env
	 *
	 * @var integer
	 */
	const DEV_ONLY_OFF = 5;
	
	/**
	 * Performs a standard print_r()
	 * 
	 * @param mixed $variable
	 * @param integer $die DIE_ON
	 * @param integer $pre PREFORMATTED_ON
	 * @param integer $devOnly DEV_ONLY_ON
	 * 
	 * @return boolean
	 */
	public static function printR($variable, $die = CustomDebug::DIE_ON, $pre = CustomDebug::PREFORMATED_ON, $devOnly = CustomDebug::DEV_ONLY_ON)
	{
		return self::output('printR', $variable, $die, $pre, $devOnly);
	}
	
	/**
	 * Performs a standard var_dump()
	 *
	 * @param mixed $variable
	 * @param integer $die DIE_ON
	 * @param integer $pre PREFORMATTED_ON
	 * @param integer $devOnly DEV_ONLY_ON
	 *
	 * @return boolean
	 */
	public static function varDump($variable = null, $die = CustomDebug::DIE_ON, $pre = CustomDebug::PREFORMATED_ON, $devOnly = CustomDebug::DEV_ONLY_ON)
	{
		return self::output('varDump', $variable, $die, $pre, $devOnly);
	}
	
	/**
	 * Performs Doctrine dump
	 * this hides the proxy classes and makes the entities smaller and easier to read
	 *
	 * @param mixed $variable
	 * @param integer $die DIE_ON
	 * @param integer $pre PREFORMATTED_ON
	 * @param integer $devOnly DEV_ONLY_ON
	 *
	 * @return boolean
	 */
	public static function doctrineDump($variable = null, $die = CustomDebug::DIE_ON, $pre = CustomDebug::PREFORMATED_ON, $devOnly = CustomDebug::DEV_ONLY_ON)
	{
		return self::output('doctrineDump', $variable, $die, $pre, $devOnly);
	}
	
	/**
	 * Output
	 * 
	 * @param string $callingFunction
	 * @param mixed $variable
	 * @param integer $die DIE_ON
	 * @param integer $pre PREFORMATTED_ON
	 * @param integer $devOnly DEV_ONLY_ON
	 *
	 * @return boolean
	 */
	protected static function output($callingFunction, $variable, $die = CustomDebug::DIE_ON, $pre = CustomDebug::PREFORMATED_ON, $devOnly = CustomDebug::DEV_ONLY_ON)
	{
		//if (\App::environment() != 'dev' && $devOnly == CustomDebug::DEV_ONLY_ON)
		//{
		//	return false;
		//}
		
		echo ($pre = CustomDebug::PREFORMATED_ON) ? '<pre>' : '';
		
		if ($callingFunction == 'varDump')
			echo var_dump($variable);
		else if ($callingFunction == 'doctrineDump')
			DoctrineDebug::dump($variable);
		else if ($callingFunction == 'printR')
			echo print_r($variable);
		else
			echo print_r($variable);
		
		echo ($pre = CustomDebug::PREFORMATED_ON) ? '</pre>' : '';
			
		if ($die == CustomDebug::DIE_ON)
		{
			die();
		}
		else
		{
			return true;
		}
	}
}