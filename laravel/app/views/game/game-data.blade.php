<div id="data">
	<h4 class="center">Data</h4>
	
	<div class="data-element">
		<span class="data-label" for="playerOne">playerOne</span>
		<span class="data-span">{{ $playerOne }}</span>
		{{ Form::hidden('playerOne', $playerOne, array('id' => 'playerOne')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="playerTwo">playerTwo</span>
		<span class="data-span">{{ $playerTwo }}</span>
		{{ Form::hidden('playerTwo', $playerTwo, array('id' => 'playerTwo')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="playerThree">playerThree</span>
		<span class="data-span">{{ $playerThree }}</span>
		{{ Form::hidden('playerThree', $playerThree, array('id' => 'playerThree')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="numberOfPlayers">numberOfPlayers</span>
		<span class="data-span">{{ $numberOfPlayers }}</span>
		{{ Form::hidden('numberOfPlayers', $numberOfPlayers, array('id' => 'numberOfPlayers')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="round">round</span>
		<span class="data-span">{{ $round }}</span>
		{{ Form::hidden('round', $round, array('id' => 'round')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="category">category</span>
		<span class="data-span">{{ $puzzle->category->name }}</span>
		{{ Form::hidden('category', $puzzle->category->name, array('id' => 'category')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="answer">answer</span>
		<span class="data-span">{{ $puzzle->answer }}</span>
		{{ Form::hidden('answer', $puzzle->answer, array('id' => 'answer')) }}
	</div>
	
	<div class="data-element">
		<span class="data-label" for="baseUrl">baseUrl</span>
		<span class="data-span">{{ URL::to('/') }}</span>
		{{ Form::hidden('baseUrl', URL::to('/'), array('id' => 'baseUrl')) }}
	</div>
	
	<div class="clear"></div>
</div> 