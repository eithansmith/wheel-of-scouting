<?php

namespace WheelOfScouting\Objects\Puzzle;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use WheelOfScouting\Services\Debug\CustomDebug as Debug;
use \Exception;

/**
 * Puzzle
 * 
 * @package WheelOfScouting/Objects/Puzzle/Puzzle
 * 
 */
class Puzzle extends Eloquent {	
	
	//protected $table = 'puzzles';
	protected $table = 'puzzles_scouts';
	
	protected $guarded = array('id');
	
	protected $answer;
	
	public function category()
	{
		return $this->belongsTo('WheelOfScouting\Objects\Category\Category', 'category_id');
	}
	
	public function getLastPlayedAttribute($value)
	{
		if (is_null($value))
			return '';
		else
		{
			//Debug::varDump($value);
			$date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
			return $date->format('m/d/Y');
		}
	}
	
	public function getAnswerAttribute()
	{
		$answer = '';
		for ($i = 1; $i <= 10; $i++)
		{
			$variableName = "word_$i";
			
			if (! is_null($this->$variableName))
			{
				$answer .= $this->$variableName.' ';
			}
		}
		return trim($answer);
	}
	
	public static function findAll()
	{
		$puzzles = Puzzle::with('category')
			->orderBy('last_played', 'desc')
			->orderBy('id')
			->get();
		
		//Debug::varDump($puzzles);
		
		return $puzzles;
	}
	
	public static function findNext($id)
	{
		$next = Puzzle::where('id', '>', $id)->first();

		// id is the last puzzle - 
		// instead of next puzzle loop back and return the first
		if ($next === null)
		{	
			$next = Puzzle::orderBy('id')->first();
		}
		//Debug::varDump($next);
		
		return $next;
	}
	
	public static function findRandom()
	{
		// return list of unplayed puzzles
		$randomIds = Puzzle::whereNull('last_played')->lists('id');
		
		// if all puzzles have been played just get all of the puzzles
		if (empty($randomIds))
			$randomIds = Puzzle::orderBy('id')->lists('id');
		
		//randomly get puzzle from the list
		$randomPuzzleId = $randomIds[array_rand($randomIds)];
		
		//Debug::varDump($randomPuzzleId);
	
		return Puzzle::findById($randomPuzzleId);
	}
	
	public static function findById($id)
	{
		$puzzle = Puzzle::findOrFail($id);
	
		//Debug::varDump($puzzle);
	
		return $puzzle;
	}
	
	public static function modify($input)
	{
		//Debug::varDump($input);
		
		// update
		if (isset($input['id']))
		{	
			$puzzle = Puzzle::findById($input['id']);
			//Debug::varDump($puzzle);
		}
		else
		{
			// insert			
			$puzzle = new Puzzle();
		}
		
		$answer = Puzzle::parseAnswer($input['answer']);
		//Debug::varDump($answer);
			
		$puzzle->category_id = $input['category'];
		$puzzle->word_1 = $answer['word_1'];
		$puzzle->word_2 = $answer['word_2'];
		$puzzle->word_3 = $answer['word_3'];
		$puzzle->word_4 = $answer['word_4'];
		$puzzle->word_5 = $answer['word_5'];
		$puzzle->word_6 = $answer['word_6'];
		$puzzle->word_7 = $answer['word_7'];
		$puzzle->word_8 = $answer['word_8'];
		$puzzle->word_9 = $answer['word_9'];
		$puzzle->word_10 = $answer['word_10'];
		$puzzle->word_number = $answer['word_number'];
		$puzzle->letter_number = $answer['letter_number'];
		$puzzle->difficulty = $input['difficulty'];

		//Debug::varDump($puzzle);
		
		return $puzzle->save();
	}
	
	public static function markPlayed($id)
	{
		$puzzle = Puzzle::findById($id);
		
		$puzzle->last_played = new \DateTime();
		
		//Debug::varDump($puzzle);
	
		return $puzzle->save();
	}
	
	public static function clearLastPlayed()
	{
		$puzzle = new Puzzle;
		return DB::table($puzzle->getTable())->update(array('last_played' => null));
	}
	
	private static function parseAnswer($answer)
	{
		$answer = str_replace('  ', ' ', $answer);
		$answer = trim($answer);
		$answer = strtoupper($answer);
		$answer = explode(' ', $answer);
		
		$letterCount = 0;
		$parsed = array();
		
		for ($i = 0; $i < 10; $i++)
		{
			$num = $i+1;
			if (isset($answer[$i]))
			{
				$parsed["word_$num"] = $answer[$i];
				$letterCount += strlen($answer[$i]);
			}
			else
			{
				$parsed["word_$num"] = null;
			}
		}
		
		$parsed['word_number'] = count($answer);
		$parsed['letter_number'] = $letterCount;
		
		return $parsed;
	}
	
}