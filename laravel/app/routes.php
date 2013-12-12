<?php

namespace App;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Games
//**********
// Round One
Route::get('game/round-one/two-player/{playerOne}/{playerTwo}', array('as' => 'game/round-one/two-player', 'uses' => 'App\Controllers\GameController@roundOneTwoPlayerGame'));
Route::get('game/round-one/three-player/{playerOne}/{playerTwo}/{playerThree}', array('as' => 'game/round-one/three-player', 'uses' => 'App\Controllers\GameController@roundOneThreePlayerGame'));

//Round Two
Route::get('game/round-two/two-player/{playerOne}/{playerTwo}/{playerOneRoundOneScore}/{playerTwoRoundOneScore}', array('as' => 'game/round-two/two-player', 'uses' => 'App\Controllers\GameController@roundTwoTwoPlayerGame'));
Route::get('game/round-two/three-player/{playerOne}/{playerTwo}/{playerThree}/{playerOneRoundOneScore}/{playerTwoRoundOneScore}/{playerThreeRoundOneScore}', array('as' => 'game/round-two/three-player', 'uses' => 'App\Controllers\GameController@roundTwoThreePlayerGame'));

//Round Three
Route::get('game/round-three/two-player/{playerOne}/{playerTwo}/{playerOneRoundOneScore}/{playerTwoRoundOneScore}/{playerOneRoundTwoScore}/{playerTwoRoundTwoScore}', array('as' => 'game/round-three/two-player', 'uses' => 'App\Controllers\GameController@roundThreeTwoPlayerGame'));
Route::get('game/round-three/three-player/{playerOne}/{playerTwo}/{playerThree}/{playerOneRoundOneScore}/{playerTwoRoundOneScore}/{playerThreeRoundOneScore}/{playerOneRoundTwoScore}/{playerTwoRoundTwoScore}/{playerThreeRoundTwoScore}', array('as' => 'game/round-three/three-player', 'uses' => 'App\Controllers\GameController@roundThreeThreePlayerGame'));
//
//*********

// Puzzle
Route::get('puzzles', array('as' => 'puzzles', 'uses' => 'App\Controllers\PuzzleController@getShowAll'));
Route::get('puzzle/create', array('as' => 'create-puzzle', 'uses' => 'App\Controllers\PuzzleController@getCreate'));
Route::post('puzzle/create', array('uses' => 'App\Controllers\PuzzleController@postCreate'));
Route::get('puzzle/{puzzleId}/edit', array('as' => 'edit-puzzle', 'uses' => 'App\Controllers\PuzzleController@getEdit'));
Route::post('puzzle/{puzzleId}/edit', array('uses' => 'App\Controllers\PuzzleController@postEdit'));
Route::get('puzzle/{puzzleId}/delete', array('as' => 'delete-puzzle', 'uses' => 'App\Controllers\PuzzleController@getDelete'));
Route::get('puzzle/clear-dates', array('as' => 'cleardates-puzzle', 'uses' => 'App\Controllers\PuzzleController@getClearLastPlayedPuzzleDates'));
Route::get('puzzle/batch-insert', array('as' => 'batchinsert-puzzle', 'uses' => 'App\Controllers\PuzzleController@getBatchInsert'));

// Main Menu 
Route::get('create/two-player', array('as' => 'create/two-player', 'uses' => 'App\Controllers\MainMenuController@getCreateTwoPlayerGame'));
Route::post('create/two-player', array('uses' => 'App\Controllers\MainMenuController@postCreateTwoPlayerGame'));

Route::get('create/three-player', array('as' => 'create/three-player', 'uses' => 'App\Controllers\MainMenuController@getCreateThreePlayerGame'));
Route::post('create/three-player', array('uses' => 'App\Controllers\MainMenuController@postCreateThreePlayerGame'));

Route::get('/', array('as' => '/', 'uses' => 'App\Controllers\MainMenuController@getIndex'));