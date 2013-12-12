@extends('layouts.master')

@section('title')
	Create Two-Player Game
@stop

@section('header-css')
	@parent
	{{ HTML::style('assets/css/create-player.css'); }}
@stop

@section('content')
	{{ Form::open(array('id'=>'create-two-player-form')) }}
	<div class="center well">
		<div class="row-fluid">
			<div class="span12">
				<h2><i class="cus-ruby padded-h2-icon"></i> Two-Player Game <i class="cus-ruby padded-h2-icon"></i></h2>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<label for="player-one"><i class="cus-sport_soccer"></i> Player 1</label>
				{{ Form::text('player-one', 
					Input::old('player-one'), 
					array(
						'maxlength' => '20', 
						'placeholder' => 'Enter Your Name', 
						'class' => HTML::fieldError('player-one', Session::get('messages', ''))
					)) 
				}}	
			</div>
			<div class="span6">
				<label for="player-two"><i class="cus-sport_football"></i> Player 2</label>
				{{ Form::text('player-two', 
					Input::old('player-two'), 
					array(
						'maxlength' => '20', 
						'placeholder' => 'Enter Your Name', 
						'class' => HTML::fieldError('player-two', Session::get('messages', ''))
					)) 
				}}	
			</div>
		</div>
	</div>
	<div class="center">
		<div class="row-fluid">
			<div class="span12">
				<button type="submit" id="submit-button" class="btn btn-large btn-success"><i class="cus-television"></i><br>Play!</button>
				<a id="cancel-button" class="btn btn-large" href="{{ URL::to('') }}"><i class="cus-cancel"></i><br>Cancel</a>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	
@stop