<?php

namespace App\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use WheelOfScouting\Services\Debug\CustomDebug as Debug;
use WheelOfScouting\Objects\Puzzle\Puzzle;
use WheelOfScouting\Objects\Category\Category;

/**
 * MainController
 *
 * @package App/Controllers/MainMenuController
 */
class MainMenuController extends BaseController {

	/**
	 * Constructor
	 *
	 */
	function __construct() 
	{
		//$this->beforeFilter('auth');
	}
	
	/**
	 * GET Index
	 *
	 * @return View
	 */
	public function getIndex()
	{
		return View::make('main-menu.index');
	}
	
	/**
	 * GET Create 2 Player Game
	 *
	 * @return View
	 */
	public function getCreateTwoPlayerGame()
	{
		return View::make('main-menu.two-player');
	}
	
	/**
	 * POST Create 2 Player Game
	 *
	 * @return Redirect
	 */
	public function postCreateTwoPlayerGame()
	{
		$validation = App::make('CreateTwoPlayerGameValidation');
		if ($validation->fails())
		{
			return Redirect::route('create/two-player')->withInput();
		}
		else
		{
			//Debug::varDump(Input::all());
			return Redirect::route('game/round-one/two-player', array(
				'playerOne' => $this->sanitizeName(Input::get('player-one')),
				'playerTwo' => $this->sanitizeName(Input::get('player-two')),
			));
		}
	}
	
	/**
	 * Create 3 Player Game
	 *
	 * @return View
	 */
	public function getCreateThreePlayerGame()
	{
		return View::make('main-menu.three-player');
	}
	
	/**
	 * POST Create 3 Player Game
	 *
	 * @return Redirect
	 */
	public function postCreateThreePlayerGame()
	{
		$validation = App::make('CreateThreePlayerGameValidation');
		if ($validation->fails())
		{
			return Redirect::route('create/three-player')->withInput();
		}
		else
		{
			//Debug::varDump(Input::all());
			return Redirect::route('game/round-one/three-player', array(
					'playerOne' => $this->sanitizeName(Input::get('player-one')),
					'playerTwo' => $this->sanitizeName(Input::get('player-two')),
					'playerThree' => $this->sanitizeName(Input::get('player-three')),
			));
		}
	}
	
}