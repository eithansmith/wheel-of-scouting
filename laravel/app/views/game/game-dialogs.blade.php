<div id="puzzleSolvedModal" class="modal hide fade">
	<div class="modal-header">
		<h3><i class="cus-rosette"></i> Puzzle Solved!</h3>
	</div>
	<div class="modal-body">
		<table id="puzzleSolvedTable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Player</th>
					<th>Round One</th>
					<th>Round Two</th>
					<th>Round Three</th>
					<th>Totals</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td id="playerOneTd"><i class="cus-sport_soccer"></i> 1. {{ $playerOne }}</td>
					<td id="playerOneRoundOneScoreTd" class="scoreTd">{{ $playerOneRoundOneScore }}</td>
					<td id="playerOneRoundTwoScoreTd" class="scoreTd">{{ $playerOneRoundTwoScore }}</td>
					<td id="playerOneRoundThreeScoreTd" class="scoreTd"">{{ $playerOneRoundThreeScore }}</td>
					<td id="playerOneTotalScoreTd" class="scoreTd"></td>
				</tr>
				<tr>
					<td id="playerTwoTd"><i class="cus-sport_football"></i> 2. {{ $playerTwo }}</td>
					<td id="playerTwoRoundOneScoreTd" class="scoreTd">{{ $playerTwoRoundOneScore }}</td>
					<td id="playerTwoRoundTwoScoreTd" class="scoreTd">{{ $playerTwoRoundTwoScore }}</td>
					<td id="playerTwoRoundThreeScoreTd" class="scoreTd">{{ $playerTwoRoundThreeScore }}</td>
					<td id="playerTwoTotalScoreTd" class="scoreTd"></td>
				</tr>
				@if($numberOfPlayers == 3)
					<tr>
						<td id="playerThreeTd"><i class="cus-sport_basketball"></i> 3. {{ $playerThree }}</td>
						<td id="playerThreeRoundOneScoreTd" class="scoreTd">{{ $playerThreeRoundOneScore }}</td>
						<td id="playerThreeRoundTwoScoreTd" class="scoreTd">{{ $playerThreeRoundTwoScore }}</td>
						<td id="playerThreeRoundThreeScoreTd" class="scoreTd">{{ $playerThreeRoundThreeScore }}</td>
						<td id="playerThreeTotalScoreTd" class="scoreTd"></td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		@if ($round == 3)
			@if($numberOfPlayers == 2)
				<a class="btn" href="{{ URL::route('game/round-one/two-player', array($playerOne, $playerTwo)) }}"><i class="cus-television"></i><br>Play Again</a>
			@else
				<a class="btn" href="{{ URL::route('game/round-one/three-player', array($playerOne, $playerTwo, $playerThree)) }}"><i class="cus-television"></i><br>Play Again</a>
			@endif
				<a class="btn" href="{{ URL::route('/') }}"><i class="cus-cross"></i><br>Quit Game</a>
		@else
			<a id="play-next-round" href="#" class="btn btn-success"><i class="cus-television"></i><br>Play Next Round</a>
		@endif
	</div>
</div>

<div id="quitGameModal" class="modal hide fade">
	<div class="modal-body">
		<h3><i class="cus-error"></i> Are you sure you want to quit this game?</h3>
	</div>
	<div class="modal-footer">
			<a class="btn btn-success" href="{{ URL::route('/') }}" style="margin-right:5px;">Yes</a>
			<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
	</div>
</div>

<div id="buyVowelErrorModal" class="modal hide fade">
	<div class="modal-body">
		<h3><i class="cus-error"></i> This player does not have enough money to buy a vowel.</h3>
	</div>
	<div class="modal-footer">
			<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">OK</button>
	</div>
</div>

<div id="solvePuzzleModal" class="modal hide fade">
	<div class="modal-header">
		<h3><i class="cus-magnifier"></i> Solve The Puzzle</h3>
	</div>
	<div class="modal-body">
		<div id="answerState"></div>
		<input class="input-large input-40" id="guess">
	</div>
	<div class="modal-footer">
			<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">OK</button>
	</div>
</div>