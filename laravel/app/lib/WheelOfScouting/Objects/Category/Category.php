<?php

namespace WheelOfScouting\Objects\Category;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Puzzle
 * 
 * @package WheelOfScouting/Objects/Category/Category
 * 
 */
class Category extends Eloquent {	
	
	//protected $table = 'categories';
	protected $table = 'categories_scouts';
	
	protected $guarded = array('id');
	
	public function puzzles()
	{
		return $this->hasMany('WheelOfScouting\Objects\Puzzle\Puzzle');
	}
	
	public static function dropdown()
	{
		return Category::orderBy('name')->get()->lists('name', 'id');
	}
	
}