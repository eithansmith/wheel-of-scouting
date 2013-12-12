@section('footer-js')
	@parent
	{{ HTML::script('assets/js/puzzle-list.js') }}
@stop

<div class="row-fluid">
	<div class="span1"></div>
	<div class="span10">
		<h3 class="{{ HTML::fieldError('puzzle', Session::get('messages', '')) }}">Select One Puzzle</h3>
		<div id="puzzle-list-div">
			<table id="puzzle-list" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Select</th>
						<th>#</th>
						<th>Category</th>
						<th># Words</th>
						<th># Letters</th>
						<th>Difficulty</th>
						<th>Last Played</th>
					</tr>
				</thead>
				<tbody>
					@foreach($puzzles as $puzzle)
						@if(Input::old('puzzle') == $puzzle->id)
						<tr class="tr-selected">
						@else
						<tr>
						@endif	
							<td>{{ Form::radio('puzzle', $puzzle->id) }} </td>
							<td>{{ $puzzle->id }}</td>
							<td>{{ $puzzle->category->name }}</td>
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