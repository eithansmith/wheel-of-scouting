<?php

namespace App\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Event;
use WheelOfScouting\Services\Debug\CustomDebug as Debug;
use WheelOfScouting\Objects\Puzzle\Puzzle;

/**
 * GameController
 *
 * @package App/Controllers/GameController
 */
class GameController extends BaseController {

	/**
	 * Constructor
	 *
	 */
	function __construct() 
	{	
		$this->puzzle = Puzzle::findRandom();
		//$this->puzzle = Puzzle::findById(6);
		
		// mark current puzzle as "played"
		Puzzle::markPlayed($this->puzzle->id);
		
		//$this->beforeFilter('auth');
	}
	
	/**
	 * GET Round One TwoPlayerGame
	 *
	 * @return View
	 */
	public function roundOneTwoPlayerGame($playerOne, $playerTwo)
	{
		//Debug::varDump($this->puzzle);
		
		return View::make('game.game-board')
			->with('puzzle', $this->puzzle)
			->with('playerOne', $playerOne)
			->with('playerOneRoundOneScore', '')
			->with('playerOneRoundTwoScore', '')
			->with('playerOneRoundThreeScore', '')
			->with('playerTwo', $playerTwo)
			->with('playerTwoRoundOneScore', '')
			->with('playerTwoRoundTwoScore', '')
			->with('playerTwoRoundThreeScore', '')
			->with('playerThree', null)
			->with('playerThreeRoundOneScore', null)
			->with('playerThreeRoundTwoScore', null)
			->with('playerThreeRoundThreeScore', null)
			->with('numberOfPlayers', 2)
			->with('round', 1);
	}
	
	/**
	 * GET Round One TwoPlayerGame
	 *
	 * @return View
	 */
	public function roundOneThreePlayerGame($playerOne, $playerTwo, $playerThree)
	{
		//Debug::varDump($this->puzzle);
	
		// mark current puzzle as "played"
		
		return View::make('game.game-board')
			->with('puzzle', $this->puzzle)
			->with('playerOne', $playerOne)
			->with('playerOneRoundOneScore', '')
			->with('playerOneRoundTwoScore', '')
			->with('playerOneRoundThreeScore', '')
			->with('playerTwo', $playerTwo)
			->with('playerTwoRoundOneScore', '')
			->with('playerTwoRoundTwoScore', '')
			->with('playerTwoRoundThreeScore', '')
			->with('playerThree', $playerThree)
			->with('playerThreeRoundOneScore', '')
			->with('playerThreeRoundTwoScore', '')
			->with('playerThreeRoundThreeScore', '')
			->with('numberOfPlayers', 3)
			->with('round', 1);
	}
	
	/**
	 * GET Round Two TwoPlayerGame
	 *
	 * @return View
	 */
	public function roundTwoTwoPlayerGame($playerOne, $playerTwo, $playerOneRoundOneScore, $playerTwoRoundOneScore)
	{
		//Debug::varDump($this->puzzle);
	
		// mark current puzzle as "played"
	
		return View::make('game.game-board')
		->with('puzzle', $this->puzzle)
		->with('playerOne', $playerOne)
		->with('playerOneRoundOneScore', $playerOneRoundOneScore)
		->with('playerOneRoundTwoScore', '')
		->with('playerOneRoundThreeScore', '')
		->with('playerTwo', $playerTwo)
		->with('playerTwoRoundOneScore', $playerTwoRoundOneScore)
		->with('playerTwoRoundTwoScore', '')
		->with('playerTwoRoundThreeScore', '')
		->with('playerThree', null)
		->with('playerThreeRoundOneScore', null)
		->with('playerThreeRoundTwoScore', null)
		->with('playerThreeRoundThreeScore', null)
		->with('numberOfPlayers', 2)
		->with('round', 2);
	}
	
	/**
	 * GET Round Two ThreePlayerGame
	 *
	 * @return View
	 */
	public function roundTwoThreePlayerGame($playerOne, $playerTwo, $playerThree, $playerOneRoundOneScore, $playerTwoRoundOneScore, $playerThreeRoundOneScore)
	{
		//Debug::varDump($this->puzzle);
	
		// mark current puzzle as "played"
	
		return View::make('game.game-board')
		->with('puzzle', $this->puzzle)
		->with('playerOne', $playerOne)
		->with('playerOneRoundOneScore', $playerOneRoundOneScore)
		->with('playerOneRoundTwoScore', '')
		->with('playerOneRoundThreeScore', '')
		->with('playerTwo', $playerTwo)
		->with('playerTwoRoundOneScore', $playerTwoRoundOneScore)
		->with('playerTwoRoundTwoScore', '')
		->with('playerTwoRoundThreeScore', '')
		->with('playerThree', $playerThree)
		->with('playerThreeRoundOneScore', $playerThreeRoundOneScore)
		->with('playerThreeRoundTwoScore', null)
		->with('playerThreeRoundThreeScore', null)
		->with('numberOfPlayers', 3)
		->with('round', 2);
	}
	
	/**
	 * GET Round Three TwoPlayerGame
	 *
	 * @return View
	 */
	public function roundThreeTwoPlayerGame($playerOne, $playerTwo, $playerOneRoundOneScore, $playerTwoRoundOneScore, $playerOneRoundTwoScore, $playerTwoRoundTwoScore)
	{
		//Debug::varDump($this->puzzle);
	
		// mark current puzzle as "played"
	
		return View::make('game.game-board')
		->with('puzzle', $this->puzzle)
		->with('playerOne', $playerOne)
		->with('playerOneRoundOneScore', $playerOneRoundOneScore)
		->with('playerOneRoundTwoScore', $playerOneRoundTwoScore)
		->with('playerOneRoundThreeScore', '')
		->with('playerTwo', $playerTwo)
		->with('playerTwoRoundOneScore', $playerTwoRoundOneScore)
		->with('playerTwoRoundTwoScore', $playerTwoRoundTwoScore)
		->with('playerTwoRoundThreeScore', '')
		->with('playerThree', null)
		->with('playerThreeRoundOneScore', null)
		->with('playerThreeRoundTwoScore', null)
		->with('playerThreeRoundThreeScore', null)
		->with('numberOfPlayers', 2)
		->with('round', 3);
	}
	
	/**
	 * GET Round Three ThreePlayerGame
	 *
	 * @return View
	 */
	public function roundThreeThreePlayerGame($playerOne, $playerTwo, $playerThree, $playerOneRoundOneScore, $playerTwoRoundOneScore, $playerThreeRoundOneScore, $playerOneRoundTwoScore, $playerTwoRoundTwoScore, $playerThreeRoundTwoScore)
	{
		//Debug::varDump($this->puzzle);
	
		// mark current puzzle as "played"
	
		return View::make('game.game-board')
		->with('puzzle', $this->puzzle)
		->with('playerOne', $playerOne)
		->with('playerOneRoundOneScore', $playerOneRoundOneScore)
		->with('playerOneRoundTwoScore', $playerOneRoundTwoScore)
		->with('playerOneRoundThreeScore', '')
		->with('playerTwo', $playerTwo)
		->with('playerTwoRoundOneScore', $playerTwoRoundOneScore)
		->with('playerTwoRoundTwoScore', $playerTwoRoundTwoScore)
		->with('playerTwoRoundThreeScore', '')
		->with('playerThree', $playerThree)
		->with('playerThreeRoundOneScore', $playerThreeRoundOneScore)
		->with('playerThreeRoundTwoScore', $playerThreeRoundTwoScore)
		->with('playerThreeRoundThreeScore', '')
		->with('numberOfPlayers', 3)
		->with('round', 3);
	}
	
	/**
	 * Message Interface
	 */
	protected $messages;
	
	/**
	 * Puzzle
	 */
	protected $puzzle;
	
}