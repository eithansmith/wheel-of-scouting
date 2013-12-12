@extends('layouts.master')

@section('title')
	Game Board
@stop

@section('header-css')
	@parent
	{{ HTML::style('assets/css/game-board.css'); }}
@stop

@section('footer-js')
	@parent
	{{ HTML::script('assets/js/winwheel_1.2.js'); }}
	{{ HTML::script('assets/js/game-board.js'); }}
@stop

 @section('header')
 	<div style="height:3px;"></div>
 @stop

@section('content')
	{{-- Hidden Input Tags (From PHP to Javascript) --}}
	@include('game.game-data')
	
	{{-- All Modal Pop Dialogs - Used to Alert Next Player, Choose Options, etc. --}}
	@include('game.game-dialogs')
	
	<div class="row-fluid">
		<div class="span8">
			@include('game.game-puzzle')
			
			@include('game.game-letters')
		</div>
		<div class="span4">
			@include('game.game-wheel')
		</div>
			
	</div>
	
	<div class="row-fluid">
		<div class="span3">
			@include('game.game-playerOne')
		</div>
		
		<div class="span3">
			@include('game.game-playerTwo')
		</div>
		
		<div class="span3">
			@if($numberOfPlayers == 3)
				@include('game.game-playerThree')
			@endif
		</div>
		
		<div class="span3">
			<div class="center">
				<a id="quit-button" class="btn" href="{{ URL::route('/') }}"><i class="cus-cross"></i><br>Quit Game</a>
			</div>
		</div>
	</div>
@stop