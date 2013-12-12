@extends('layouts.master')

@section('title')
	Create Puzzle
@stop

@section('header-css')
	@parent
	{{ HTML::style('assets/css/create-player.css'); }}
@stop

@section('content')
	{{ Form::open(array('id'=>'create-puzzle-form')) }}
	<div class="well">
		<div class="row-fluid">
			<div class="span1"></div>
			<div class="span10">
				<h2 class="center">Create Puzzle</h2>
				<div id="answer-div">
					<label for="answer">Answer</label>
					{{ Form::text('answer', Input::old('answer'), array(
							'maxLength' => '100',
							'class' => 'input-60 ' . HTML::fieldError('answer', Session::get('messages', ''))
						)) 
					}}
				</div>
				<div id="category-div" class="{{ HTML::fieldError('category', Session::get('messages', '')) }}">
					<label for="category">Category</label>
					{{ Form::select('category', $categoriesList, Input::old('category')) }}
				</div>
				<div id="difficulty-div" class="{{ HTML::fieldError('difficulty', Session::get('messages', '')) }}">
					<label for="difficulty">Difficulty</label>
					{{ Form::select('difficulty', array(
							'Easy' => 'Easy',
							'Medium' => 'Medium',
							'Hard' => 'Hard',
						),
						Input::old('difficulty')
						)
					}}
				</div>
			</div>
			<div class="span1"></div>
		</div>
	</div>
	<div class="center">
		<div class="row-fluid">
			<div class="span12">
				<button type="submit" id="submit-button" class="btn btn-large btn-success"><i class="cus-accept"></i><br>Create</button>
				<a id="cancel-button" class="btn btn-large" href="{{ URL::route('puzzles') }}"><i class="cus-cancel"></i><br>Cancel</a>
			</div>
		</div>
	</div>
@stop