@extends('layouts.master')

@section('title')
	Main Menu
@stop

@section('header-css')
	@parent
	{{ HTML::style('assets/css/main-menu.css'); }}
@stop

@section('content')
	<div class="center">
	  	<div id="wheel-pic-row" class="row-fluid">
	    	<div class="span12">
	    		<img id="wheel-pic" src="{{ URL::to('assets/img/wheel/wheel-of-fortune_2011.jpg') }}" class="img-circle" alt="wheel">
	    	</div>
	  	</div>
	  	<div id="audio-row" class="row-fluid">
	    	<div class="span12">
	    		<audio src="{{ URL::to('assets/audio/Wheel of Fortune.mp3') }}" controls>
					Your browser does not support the audio element.
				</audio>		
	    	</div>
	  	</div>
	  	<div id="buttons-row" class="row-fluid">
	    	<div class="span4">
	    		<a class="btn btn-large btn-success" href="{{ URL::route('create/two-player') }}"><i class="cus-user"></i><i class="cus-user"></i> <br>2-Player Game</a>		
	    	</div>
	    	<div class="span4">
	    		<a class="btn btn-large btn-success" href="{{ URL::route('create/three-player') }}"><i class="cus-user"></i><i class="cus-user"></i><i class="cus-user"></i><br>3-Player Game</a>		
	    	</div>
	    	<div class="span4">
	    		<a class="btn btn-large" href="{{ URL::route('puzzles') }}"><i class="cus-pictures"></i><i class="cus-photos"></i> <br>Puzzle Editor</a>		
	    	</div>
	  	</div>
  	</div>
@stop