<?php

namespace App\Controllers;

use WheelOfScouting\Objects\Category\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Event;
use WheelOfScouting\Objects\Puzzle\Puzzle;
use WheelOfScouting\Services\Debug\CustomDebug as Debug;

/**
 * PuzzleController
 *
 * @package App/Controllers/PuzzleController
 */
class PuzzleController extends BaseController {

	/**
	 * Constructor
	 *
	 */
	function __construct() 
	{
		$this->messages = App::make('Messages');
		
		//$this->beforeFilter('auth');
	}
	
	/**
	 * GET Show All
	 *
	 * @return View
	 */
	public function getShowAll()
	{
		$puzzles = Puzzle::findAll();
		//Debug::varDump($puzzles);
		
		return View::make('puzzle.puzzle-show-all')
			->with('puzzles', $puzzles);
	}
	
	/**
	 * GET Edit
	 *
	 * @return View
	 */
	public function getEdit($puzzleId)
	{
		$puzzle = Puzzle::findById($puzzleId);
		$categoriesList = Category::dropdown();
		//Debug::varDump($puzzle);
		//Debug::varDump($categoriesDropdown);
		
		return View::make('puzzle.puzzle-edit')
			->with('puzzle', $puzzle)
			->with('categoriesList', $categoriesList);
	}
	
	/**
	 * POST Edit
	 *
	 * @return Redirect
	 */
	public function postEdit()
	{
		$validation = App::make('PuzzleValidation');
		if ($validation->fails())
		{
			return Redirect::route('edit-puzzle', array('puzzleId' => Input::get('id')))
				->withInput();
		}
		else
		{
			//Debug::varDump(Input::all());
			$saved = Puzzle::modify(Input::all()); 
			
			return Redirect::route('puzzles');
		}
	}
	
	/**
	 * GET Delete
	 *
	 * @return View
	 */
	public function getDelete($puzzleId)
	{
		$puzzle = Puzzle::findById($puzzleId);
		
		$puzzle->delete();
		
		return Redirect::route('puzzles');
	}
	
	/**
	 * GET Create
	 *
	 * @return View
	 */
	public function getCreate()
	{
		$categoriesList = Category::dropdown();
		//Debug::varDump($categoriesDropdown);
		
		return View::make('puzzle.puzzle-create')
			->with('categoriesList', $categoriesList);
	}
	
	/**
	 * POST Create
	 *
	 * @return View
	 */
	public function postCreate()
	{
		$validation = App::make('PuzzleValidation');
		if ($validation->fails())
		{
			return Redirect::route('create-puzzle')
				->withInput();
		}
		else
		{
			//Debug::varDump(Input::all());
			$saved = Puzzle::modify(Input::all()); 
			
			return Redirect::route('puzzles');
		}
	}
	
	/**
	 * GET Clear Last Played Dates
	 */
	public function getClearLastPlayedPuzzleDates()
	{
		Puzzle::clearLastPlayed();
		
		return Redirect::route('puzzles');
	}
	
	/**
	 * Message Interface
	 */
	protected $messages;
	
}