@extends('layouts.master')

@section('title')
	Puzzle Editor
@stop

@section('header-css')
	@parent
	{{ HTML::style('assets/css/puzzle-show-all.css'); }}
@stop

@section('footer-js')
	@parent
	{{ HTML::script('assets/js/puzzle-show-all.js'); }}
@stop

@section('content')
	<div class="well">
		<div class="row-fluid">
			<div class="span1"></div>
			<div class="span10">
				<h2 class="center">Puzzle Editor</h2>
				<div id="new-puzzle-div">
					<a class="btn btn-success create-puzzle-button" href="{{ URL::route('create-puzzle') }}"><i class="cus-add"></i> New Puzzle</a>
					<a class="btn cleardates-puzzle-button" href="{{ URL::route('cleardates-puzzle') }}"><i class="cus-delete"></i> Clear Dates</a>
				</div>
				<div id="puzzle-list-div">
				<table id="puzzle-list" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Options</th>
							<th>#</th>
							<th>Category</th>
							<th>Answer (Hover to Show)</th>
							<th># Words</th>
							<th># Letters</th>
							<th>Difficulty</th>
							<th>Last Played</th>
						</tr>
					</thead>
					<tbody>
						@foreach($puzzles as $puzzle)
							<tr>	
								<td> 
									<a class="btn edit-puzzle-button" href="{{ URL::route('edit-puzzle', array($puzzle->id)) }}"><i class="cus-pencil"></i> Edit</a>
									<a class="btn delete-puzzle-button" href="{{ URL::route('delete-puzzle', array($puzzle->id)) }}"><i class="cus-delete"></i> Delete</a>
								</td>
								<td>{{ $puzzle->id }}</td>
								<td>{{ $puzzle->category->name }}</td>
								<td><span class="answer">{{ $puzzle->answer }}</span></td>
								<td>{{ $puzzle->word_number }}</td>
								<td>{{ $puzzle->letter_number }}</td>	
								<td>
									@if ($puzzle->difficulty == 'Easy')
										<img src="{{ URL::to('assets/img/wheel/star.png') }}" alt="star" title="Easy">
										<img src="{{ URL::to('assets/img/wheel/empty-star.png') }}" alt="star" title="Easy">
										<img src="{{ URL::to('assets/img/wheel/empty-star.png') }}" alt="star" title="Easy">
									@elseif ($puzzle->difficulty == 'Medium')
										<img src="{{ URL::to('assets/img/wheel/star.png') }}" alt="star" title="Medium">
										<img src="{{ URL::to('assets/img/wheel/star.png') }}" alt="star" title="Medium">
										<img src="{{ URL::to('assets/img/wheel/empty-star.png') }}" alt="star" title="Medium">
									@elseif ($puzzle->difficulty == 'Hard')
										<img src="{{ URL::to('assets/img/wheel/star.png') }}" alt="star" title="Hard">
										<img src="{{ URL::to('assets/img/wheel/star.png') }}" alt="star" title="Hard">
										<img src="{{ URL::to('assets/img/wheel/star.png') }}" alt="star" title="Hard">
									@endif
								</td>
								<td>{{ $puzzle->last_played }}</label></td>		
							</tr>
						@endforeach
						
						@if (empty($puzzles))
							<tr><td colspan="7">No puzzles</td></tr>
						@endif
					</tbody>
				</table>
				</div>
			</div>
			<div class="span1"></div>
		</div>
	</div>
	<div class="center">
		<div class="row-fluid">
			<div class="span12">
				<a id="cancel-button" class="btn btn-large" href="{{ URL::route('/') }}"><i class="cus-arrow_left"></i><br>Main Menu</a>
			</div>
		</div>
	</div>
@stop