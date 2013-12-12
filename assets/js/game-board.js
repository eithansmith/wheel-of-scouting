baseUrl = $('input#baseUrl').val();
//baseUrl = 'http://ruddymysterious.com/wheel-of-scouting/';

var game = {
    
    players : [],
    playerNames : [],
    
    round : null,
    
    currentMode : null,
    
    SpinBuySolve : 0,
    Spinning : 1,
    PickConsonant : 2,
    PickVowel : 3,
    SolvePuzzle: 4,
    
    numberPlayers : 0,
    whosTurnIndex : 0,
    activePlayer : null,
    
    gameOver : false,
    
    category : null,
    
    answer : null,
    answerState : null,
    
    canvas : null,
    
    context : null,
    
    image : null,
    
    // only 20 character per row - at 2 words per row this could be tricky
    // database allows 20 characters per word so be careful when created puzzles 
    col : [50, 90, 130, 170, 210, 250, 290, 330, 370, 410, 450, 490, 530, 570, 610, 650, 690, 730, 770, 810],
    
    // 5 rows allows - 10 words at 2 words per row
    row : [50, 125, 200, 275, 350],
    
    boxWidth : 29,
    boxHeight : 46,
    
    currentSpace : null,
    currentSpaceValue : null,
    
    soundSpin : null,
    soundCategory : null,
    soundBankrupt : null,
    soundLetterFound : null,
    soundLetterNotFound : null,
    soundOnlyVowelsRemain : null,
    soundPuzzleSolved: null,
    
    onlyVowelsSoundPlayed : false, //so that we only play it once
    
    isEven: function(x) {
    	return (x % 2) == 0;
    },
    
    isOdd: function(x) {
    	return !game.isEven(x);
    },
    
    getNumberLettersInAnswer: function(letter) {
    	// if the letter has already been used, return 0
    	// otherwise return the number of letters present in the answer
    	if ((game.answerState.split(letter).length - 1) > 0)
    		return 0;
    	else
    		return game.answer.split(letter).length - 1;
    },
    
    routeKeyboardAction: function(keyCode) {
    	
    	if (game.currentMode == game.SpinBuySolve)
    	{
    		switch(keyCode)
        	{
        		case 83: // S
        		case 115: // s
    				game.spin();
    				break;
        		case 66: // B
        		case 98: // b
    				game.buyVowel();
    				break;
        		case 79: // O
        		case 111: // o
        			game.currentMode = game.SolvePuzzle;
        			//add answerState to the modal
        			$('div#answerState').html(game.answerState.replace(/\*/g, '-').replace(/ /g, '<br>'));
        			//show modal
        	    	$('#solvePuzzleModal').modal();
    				break;
        	}
    	}
    	else if (game.currentMode == game.PickConsonant)
    	{
    		switch(keyCode)
        	{
	        	case 66: // B
	    		case 98: // b
					game.pickConsonant('B');
					break;
	    		case 67: // C
	    		case 99: // c
					game.pickConsonant('C');
					break;
	    		case 68: // D
	    		case 100: // d
					game.pickConsonant('D');
					break;
	    		case 70: // F
	    		case 102: // f
					game.pickConsonant('F');
					break;
	    		case 71: // G
	    		case 103: // g
					game.pickConsonant('G');
					break;
	    		case 72: // H
	    		case 104: // h
					game.pickConsonant('H');
					break;
	    		case 74: // J
	    		case 106: // j
					game.pickConsonant('J');
					break;
	    		case 75: // K
	    		case 107: // k
					game.pickConsonant('K');
					break;
	    		case 76: // L
	    		case 108: // l
					game.pickConsonant('L');
					break;
	    		case 77: // M
	    		case 109: // m
					game.pickConsonant('M');
					break;
	    		case 78: // N
	    		case 110: // n
					game.pickConsonant('N');
					break;
	    		case 80: // P
	    		case 112: // p
					game.pickConsonant('P');
					break;
	    		case 81: // Q
	    		case 113: // q
					game.pickConsonant('Q');
					break;
	    		case 82: // R
	    		case 114: // r
					game.pickConsonant('R');
					break;
        		case 83: // S
        		case 115: // s
    				game.pickConsonant('S');
    				break;
        		case 84: // T
	    		case 116: // t
					game.pickConsonant('T');
					break;
	    		case 86: // V
	    		case 118: // v
					game.pickConsonant('V');
					break;
	    		case 87: // W
	    		case 119: // w
					game.pickConsonant('W');
					break;
	    		case 88: // X
	    		case 120: // x
					game.pickConsonant('X');
					break;
	    		case 89: // Y
	    		case 121: // y
					game.pickConsonant('Y');
					break;
	    		case 90: // Z
	    		case 122: // z
					game.pickConsonant('Z');
					break;
        	}
    	}
    	else if (game.currentMode == game.PickVowel)
    	{
    		switch(keyCode)
        	{
        		case 65: // A
        		case 97: // a
    				game.pickVowel('A');
    				break;
        		case 69: // E
        		case 101: // e
    				game.pickVowel('E');
    				break;
        		case 73: // I
        		case 105: // i
    				game.pickVowel('I');
    				break;
        		case 79: // O
        		case 111: // o
    				game.pickVowel('O');
    				break;
        		case 85: // U
        		case 117: // u
    				game.pickVowel('U');
    				break;
        	}
    	}
    },
    
    changePlayers: function() {
    	game.whosTurnIndex++;
    	
    	if (game.whosTurnIndex >= game.numberPlayers) // reached the end - go back to first
    		game.whosTurnIndex = 0;
    	
    	game.activePlayer = game.players[game.whosTurnIndex];
    	
    	$('div#playerOne-frame,div#playerTwo-frame,div#playerThree-frame').removeClass('selected-player');
    	$('div#'+game.activePlayer+'-frame').addClass('selected-player');
    	
    	$('button.player-button').attr('disabled', 'disabled');
    	$('button#'+game.activePlayer+'-spin-button,button#'+game.activePlayer+'-buy-button,button#'+game.activePlayer+'-solve-button,').removeAttr('disabled');
    	
    	game.currentMode = game.SpinBuySolve;
    	
    	//console.log(game.activePlayer);
    },
    
    spin: function() {
    	game.currentMode = game.Spinning;
    	
    	// trigger wheel spin
    	//wheel.spin();
    	game.soundSpin.play();
    	
    	resetWheel();
    	powerSelected(1);
		startSpin();
		
		// no more clicking the buttons
		$('button.player-button').attr('disabled', 'disabled');
		
		//wait until the wheel is finished spinning
		setTimeout(function() {
			
			//game.currentSpace = wheel.getCurrentSpace();
			game.currentSpace = currentPrize;
			game.currentSpaceValue = parseInt(game.currentSpace
				.replace('BANKRUPT', '')
				.replace('LOSE A TURN', '')
				.replace('$', '')
				.replace(' ', '')
			);
			
			if (game.currentSpace == 'BANKRUPT')
				game.bankrupt();
			else if (game.currentSpace == 'LOSE A TURN')
				game.loseTurn();
			else
			{
				$('button.consonant-button').removeAttr('disabled'); //you can now click on letters
				game.currentMode = game.PickConsonant;
			}
			
		}, 10000);
    },
    
    bankrupt: function() {
    	//play bankrupt sound
    	game.soundBankrupt.play();
    	//wait until sound is finished
		setTimeout(function() {
			//wipe out their money
			$('span#'+game.activePlayer+'-score').attr('data-score', 0).html('$ 0');
			//change players
			game.changePlayers();
		}, 3000);
    },
    
    loseTurn: function() {
    	//play bankrupt sound (there is no lose turn sound by the way)
    	game.soundBankrupt.play();
    	//wait until sound is finished
		setTimeout(function() {
			//change players
			game.changePlayers();
		}, 3000);
    },
    
    pickConsonant : function(letter) {
    	//remove letter from the list (mark it used)
    	$('button#'+letter)
    		.removeClass('btn')
    		.removeClass('btn-large')
    		.removeClass('letter-button')
    		.addClass('letter-used');
    	
		// disabled the consonant letter buttons
		$('button.letter-button').attr('disabled', 'disabled');
		$('button.consonant-button').attr('disabled', 'disabled');
    	
    	// calculate number of letters found in puzzle
    	var numLetters = game.getNumberLettersInAnswer(letter);
    	
    	if (numLetters == 0)
    	{
    		game.soundLetterNotFound.play();
    		game.changePlayers();
    	}
    	else
    	{
    		game.soundLetterFound.play();

    		// update the answerState to show letters instead of * characters
    		game.updateAnswerState(letter);
    		
    		// reveal the spaces on the board
    		game.clearBoard();
    		game.drawBoard();
    		
    		// calculate the score and add it to the total for that player
    		var scoreThisTurn = game.currentSpaceValue * numLetters;
    		var oldScore = $('span#'+game.activePlayer+'-score').attr('data-score');
    		var newScore = parseInt(oldScore) + parseInt(scoreThisTurn);
    		var newScoreHTML = '$ '+newScore;   		
    		$('span#'+game.activePlayer+'-score').attr('data-score', newScore).html(newScoreHTML);
    		
    		// re-enable the player's buttons
    		$('button#'+game.activePlayer+'-spin-button,button#'+game.activePlayer+'-buy-button,button#'+game.activePlayer+'-solve-button,').removeAttr('disabled');
    		
    		game.currentMode = game.SpinBuySolve;
    	}
    },
    
    pickVowel : function(letter) {
    	//remove letter from the list (mark it used)
    	$('button#'+letter)
    		.removeClass('btn')
    		.removeClass('btn-large')
    		.removeClass('letter-button')
    		.addClass('letter-used');
    	
    	// deducted 250 from their score
		var oldScore = $('span#'+game.activePlayer+'-score').attr('data-score');
		var newScore = parseInt(oldScore) - 250;
		var newScoreHTML = '$ '+newScore;   		
		$('span#'+game.activePlayer+'-score').attr('data-score', newScore).html(newScoreHTML);
    	
		// disabled the vowel letter buttons
		$('button.letter-button').attr('disabled', 'disabled');
		$('button.vowel-button').attr('disabled', 'disabled');
		
		// calculate number of letters found in puzzle
    	var numLetters = game.getNumberLettersInAnswer(letter);
		
    	if (numLetters == 0)
    	{
    		game.soundLetterNotFound.play();
    		game.changePlayers();
    	}
    	else
    	{
    		game.soundLetterFound.play();

    		// update the answerState to show letters instead of * characters
    		game.updateAnswerState(letter);
    		
    		// reveal the spaces on the board
    		game.clearBoard();
    		game.drawBoard();
    		
    		// re-enable the player's buttons
    		$('button#'+game.activePlayer+'-spin-button,button#'+game.activePlayer+'-buy-button,button#'+game.activePlayer+'-solve-button,').removeAttr('disabled');
    		
    		game.currentMode = game.SpinBuySolve;
    	}
    },
    
    buyVowel : function() {
    	var oldScore = $('span#'+game.activePlayer+'-score').attr('data-score');
    	
    	if (oldScore < 250)
    	{
    		$('#buyVowelErrorModal').modal();
    		return false;
    	}
    	
    	$('button.letter-button').attr('disabled', 'disabled');
    	$('button.vowel-button').removeAttr('disabled'); //you can now click on vowels
    	
    	game.currentMode = game.PickVowel;
    },
    
    solvePuzzle : function() {
    	
    	var guess = $('input#guess').val();
    	
    	$('input#guess').val('');
    	
    	if (guess.trim().toUpperCase() == game.answer.trim().toUpperCase())
    	{
    		//update the answer state with the real answer
    		game.answerState = game.answer;
    		
    		// reveal the spaces on the board
    		game.clearBoard();
    		game.drawBoard();
    	}
    	else
    	{
    		game.soundLetterNotFound.play();
    		game.changePlayers();
    	}
    },
    
    triggerGameEnd : function() {
    	// play game winning sound
    	game.soundPuzzleSolved.play();
		
    	// store winning payers score and add 1000 to it
		var oldScore = $('span#'+game.activePlayer+'-score').attr('data-score');
		var newScore = oldScore;
		if (oldScore < 1000)
			newScore = 1000;
		var newScoreHTML = '$ '+newScore;
		
		// wipe out everyones scores
		$('span.player-score').attr('data-score', 0).html('$ 0');
		
		// add wining players score back
		$('span#'+game.activePlayer+'-score').attr('data-score', newScore).html(newScoreHTML);

		var nextPuzzleLink = baseUrl+'/game';
		
		//update the puzzle modal with accurate scores
		if (game.round == 1)
		{
			nextPuzzleLink = nextPuzzleLink+'/round-two';
			
			//get the round one scores
			var playerOneRoundOneScore = parseInt($('span#playerOne-score').attr('data-score'));
			var playerTwoRoundOneScore = parseInt($('span#playerTwo-score').attr('data-score'));
			
			$('td#playerOneRoundOneScoreTd').html(playerOneRoundOneScore);
			$('td#playerTwoRoundOneScoreTd').html(playerTwoRoundOneScore);
			
			// calculate totals
			$('td#playerOneTotalScoreTd').html(playerOneRoundOneScore);
			$('td#playerTwoTotalScoreTd').html(playerTwoRoundOneScore);
			
			if (game.numberPlayers == 3)
			{
				var playerThreeRoundOneScore = parseInt($('span#playerThree-score').attr('data-score'));
				
				$('td#playerThreeRoundOneScoreTd').html(playerThreeRoundOneScore);
				$('td#playerThreeTotalScoreTd').html(playerThreeRoundOneScore);
				
				nextPuzzleLink = nextPuzzleLink+'/three-player/'
					+game.playerNames[0]
					+'/'+game.playerNames[1]
					+'/'+game.playerNames[2]
					+'/'+playerOneRoundOneScore
					+'/'+playerTwoRoundOneScore
					+'/'+playerThreeRoundOneScore;
			}
			else
			{
				nextPuzzleLink = nextPuzzleLink+'/two-player/'
					+game.playerNames[0]
					+'/'+game.playerNames[1]
					+'/'+playerOneRoundOneScore
					+'/'+playerTwoRoundOneScore;
			}
			
			$('a#play-next-round').attr('href', nextPuzzleLink);
		}
		else if (game.round == 2)
		{
			nextPuzzleLink = nextPuzzleLink+'/round-three';
			
			// get round one scores
			var playerOneRoundOneScore = parseInt($('td#playerOneRoundOneScoreTd').html());
			var playerTwoRoundOneScore = parseInt($('td#playerTwoRoundOneScoreTd').html());
			
			// get round two scores
			var playerOneRoundTwoScore = parseInt($('span#playerOne-score').attr('data-score'));
			var playerTwoRoundTwoScore = parseInt($('span#playerTwo-score').attr('data-score'));
			
			// write current round scores to modal
			$('td#playerOneRoundTwoScoreTd').html(playerOneRoundTwoScore);
			$('td#playerTwoRoundTwoScoreTd').html(playerTwoRoundTwoScore);
			
			// calculate total scores and write to modal
			$('td#playerOneTotalScoreTd').html(playerOneRoundOneScore + playerOneRoundTwoScore);
			$('td#playerTwoTotalScoreTd').html(playerTwoRoundOneScore + playerTwoRoundTwoScore);
			
			if (game.numberPlayers == 3)
			{
				var playerThreeRoundOneScore = parseInt($('td#playerThreeRoundOneScoreTd').html());
				var playerThreeRoundTwoScore = parseInt($('span#playerThree-score').attr('data-score'));
				
				$('td#playerThreeRoundTwoScoreTd').html(playerThreeRoundTwoScore);
				$('td#playerThreeTotalScoreTd').html(playerThreeRoundOneScore + playerThreeRoundTwoScore);
				
				nextPuzzleLink = nextPuzzleLink+'/three-player/'
					+game.playerNames[0]
					+'/'+game.playerNames[1]
					+'/'+game.playerNames[2]
					+'/'+playerOneRoundOneScore
					+'/'+playerTwoRoundOneScore
					+'/'+playerThreeRoundOneScore
					+'/'+playerOneRoundTwoScore
					+'/'+playerTwoRoundTwoScore
					+'/'+playerThreeRoundTwoScore;
			}
			else
			{
				nextPuzzleLink = nextPuzzleLink+'/two-player/'
					+game.playerNames[0]
					+'/'+game.playerNames[1]
					+'/'+playerOneRoundOneScore
					+'/'+playerTwoRoundOneScore
					+'/'+playerOneRoundTwoScore
					+'/'+playerTwoRoundTwoScore;
			}
			
			$('a#play-next-round').attr('href', nextPuzzleLink);
		}
		else if (game.round == 3)
		{	
			// get round one scores
			var playerOneRoundOneScore = parseInt($('td#playerOneRoundOneScoreTd').html());
			var playerTwoRoundOneScore = parseInt($('td#playerTwoRoundOneScoreTd').html());
			
			// get round two scores
			var playerOneRoundTwoScore = parseInt($('td#playerOneRoundTwoScoreTd').html());
			var playerTwoRoundTwoScore = parseInt($('td#playerTwoRoundTwoScoreTd').html());
			
			// get round three scores
			var playerOneRoundThreeScore = parseInt($('span#playerOne-score').attr('data-score'));
			var playerTwoRoundThreeScore = parseInt($('span#playerTwo-score').attr('data-score'));
			
			// write current round scores to modal
			$('td#playerOneRoundThreeScoreTd').html(playerOneRoundThreeScore);
			$('td#playerTwoRoundThreeScoreTd').html(playerTwoRoundThreeScore);
			
			// calculate total scores and write to modal
			$('td#playerOneTotalScoreTd').html(playerOneRoundOneScore + playerOneRoundTwoScore + playerOneRoundThreeScore);
			$('td#playerTwoTotalScoreTd').html(playerTwoRoundOneScore + playerTwoRoundTwoScore + playerTwoRoundThreeScore);
			
			if (game.numberPlayers == 3)
			{
				var playerThreeRoundOneScore = parseInt($('td#playerThreeRoundOneScoreTd').html());
				var playerThreeRoundTwoScore = parseInt($('td#playerThreeRoundTwoScoreTd').html());
				var playerThreeRoundThreeScore = parseInt($('span#playerThree-score').attr('data-score'));
				
				$('td#playerThreeRoundThreeScoreTd').html(playerThreeRoundThreeScore);
				$('td#playerThreeTotalScoreTd').html(playerThreeRoundOneScore + playerThreeRoundTwoScore + playerThreeRoundThreeScore);
				
			}
			
		}
		
		$('#puzzleSolvedModal').modal({
			backdrop: 'static',
			keyboard: false
		});
    },
    
    init: function(optionList) {
        try {
        	game.initAudio();
            game.initPlayers();
            game.initPuzzle();
            
            game.drawBoard();
            
            // play the new puzzle starting sound
            game.soundCategory.play();
            
            game.currentMode = game.SpinBuySolve;
            
            $.extend(game, optionList);

        } catch (exceptionData) {
            alert('Game is not loaded ' + exceptionData);
        }
        
        
    },
    
    initPlayers: function() {
        var playerOneName = $('#playerOne').val();     
        if (playerOneName)
        {
        	game.players.push('playerOne');
        	game.playerNames.push(playerOneName);
        }
        
        var playerTwoName = $('#playerTwo').val();     
        if (playerTwoName)
        {
        	game.players.push('playerTwo');
        	game.playerNames.push(playerTwoName);
        }
        
        var playerThreeName = $('#playerThree').val();     
        if (playerThreeName)
        {
        	game.players.push('playerThree');
        	game.playerNames.push(playerThreeName);
        }
        
        game.numberPlayers = game.players.length;
        game.round = $('#round').val();
        
        // determine who goes first
        if (game.round == 1)
        {
        	game.whosTurnIndex = 0; //player one
        }
        else if (game.round == 2)
        {
        	game.whosTurnIndex = 1; //player two
        }
        else if (game.round == 3)
        {
        	if (game.numberPlayers == 3)
        		game.whosTurnIndex = 2; //player three
        	else
        		game.whosTurnIndex = 0; //player one
        }
               
        // set active player
        game.activePlayer = game.players[game.whosTurnIndex];
    	
        // select that player and disabled other players' buttons
    	$('div#playerOne-frame,div#playerTwo-frame,div#playerThree-frame').removeClass('selected-player');
    	$('div#'+game.activePlayer+'-frame').addClass('selected-player');
    	
    	$('button.player-button').attr('disabled', 'disabled');
    	$('button#'+game.activePlayer+'-spin-button,button#'+game.activePlayer+'-buy-button,button#'+game.activePlayer+'-solve-button,').removeAttr('disabled');
        
        $('button.letter-button').attr('disabled', 'disabled');
        
    	//console.log(game);
    },
    
    initPuzzle: function() {
    	// set category, answer, word, from hidden inputs
    	game.category = $('#category').val(); 
    	game.answer = $('#answer').val();
    	
    	//set answerState (current answer - replace letters with * and keep spaces)
    	game.answerState = '';
    	for(var i = 0; i < game.answer.length; i++)
    	{
    		if (game.answer[i] == ' ')
    			game.answerState += ' ';
    		else if (game.answer[i].match(/^[A-Za-z]+$/))
    			game.answerState += '*';
    		else
    			game.answerState += game.answer[i];
    	}
    	
    	//console.log(game.answerState);
    },
    
    initAudio: function() {
    	var soundSpin = document.createElement('audio');
    	soundSpin.setAttribute('src', baseUrl+'/assets/audio/uspin.mp3');
        game.soundSpin = soundSpin;
    	
    	var soundCategory = document.createElement('audio');
    	soundCategory.setAttribute('src', baseUrl+'/assets/audio/ucategory.wav');
        game.soundCategory = soundCategory;
        
        var soundBankrupt = document.createElement('audio');
        soundBankrupt.setAttribute('src', baseUrl+'/assets/audio/ubankrupt.wav');
        game.soundBankrupt = soundBankrupt;
        
        var soundLetterFound = document.createElement('audio');
        soundLetterFound.setAttribute('src', baseUrl+'/assets/audio/uinpuzz.wav');
        game.soundLetterFound = soundLetterFound;
        
        var soundLetterNotFound = document.createElement('audio');
        soundLetterNotFound.setAttribute('src', baseUrl+'/assets/audio/ubuzzer.wav');
        game.soundLetterNotFound = soundLetterNotFound;
        
        var soundOnlyVowelsRemain = document.createElement('audio');
        soundOnlyVowelsRemain.setAttribute('src', baseUrl+'/assets/audio/uchirps.wav');
        game.soundOnlyVowelsRemain = soundOnlyVowelsRemain;
        
        var soundPuzzleSolved = document.createElement('audio');
        soundPuzzleSolved.setAttribute('src', baseUrl+'/assets/audio/applause-3.mp3');
        game.soundPuzzleSolved = soundPuzzleSolved;
    },
    
    updateAnswerState: function(letter) {
    	
    	// build an array of positions for the letter
    	var positions = [];
		var position = 0;
		while(game.answer.indexOf(letter, position) > -1)
		{
			var index = game.answer.indexOf(letter, position);
			positions.push(index);
			position = index + 1;
		}
    	
		//console.log(positions);
		
		//loop through those positions and modify the answer state
		for (var i = 0; i < positions.length; i++)
		{
			game.answerState = game.answerState.substr(0, positions[i]) + letter + game.answerState.substring(positions[i] + 1);
		}
		
		//console.log(game.answerState);
    },
    
    onlyVowelsLeft: function() {
    	
    	// build an array of positions for '*' from the answer state
    	var positions = [];
		var position = 0;
		while(game.answerState.indexOf('*', position) > -1)
		{
			var index = game.answerState.indexOf('*', position);
			positions.push(index);
			position = index + 1;
		}
    	
		//console.log(positions);
		
		var isVowel, letter;
		//loop through those positions and check to make sure letters are vowels
		for (var i = 0; i < positions.length; i++)
		{
			letter = game.answer[positions[i]];
			isVowel = (letter == 'A' || letter == 'E' || letter == 'I' || letter == 'O' || letter == 'U');
			
			//if (/[aeiou]/.test(game.answer[i]) === false)
			if (!isVowel)
				return false;
		}
		
		return true;
    },
    
    drawBoard: function() {
    	// set canvas and title
    	game.canvas = document.getElementById('puzzle-canvas');
    	game.context = game.canvas.getContext('2d');
    	
    	game.context.fillStyle = '#608341';
		game.context.fillRect(0, 0, 900, 400);
		
		game.canvas.style.border = "#FFD800 8px solid";
    	
    	// add category to board
    	game.context.shadowColor = 'black';
    	game.context.shadowOffsetX = 1;
    	game.context.shadowOffsetY = 1;
    	game.context.shadowBlur = 25;
    	game.context.font = '20pt Verdana';
    	game.context.fillStyle = '#FFFFFF';
    	game.context.fillText('Round ' + game.round + ': ' + game.category, 50, 30);
    	
    	// loop through answer state and write boxes
    	var row = 1, word = 1;
    	var colIndex = -1, rowIndex = 0;
    	
    	for (var i = 0; i < game.answerState.length; i++)
    	{
    		// set column and row indexes - used to determine x y posistion of data
    		colIndex++;
    		rowIndex = row - 1;
    		
    		// if space character
    		if (game.answerState[i] == ' ')
    		{
    			// new word
    			word++;
    			if (game.isOdd(word)) // if next word is now odd (3, 5, 7, 9)
    			{
    				//then start it at next row
    				row++;
    				//and carriage return the colIndex back to -1
    				colIndex = -1;
    			}
    		}
    		else // otherwise an * or revealed letter character
    		{
    			//draw box
    			game.context.shadowColor = 'black';
    	    	game.context.shadowOffsetX = 1;
    	    	game.context.shadowOffsetY = 1;
    	    	game.context.shadowBlur = 25;
    			game.context.fillRect(game.col[colIndex], game.row[rowIndex], game.boxWidth, game.boxHeight);
    			
    			// if solved character then draw it inside the box
    			if (game.answerState[i] != '*')
    			{
    				game.context.fillStyle = '#000000';
    				game.context.shadowBlur = 1;
    				game.context.fillText(game.answerState[i], game.col[colIndex]+4, game.row[rowIndex]+34);
    		    	game.context.fillStyle = '#FFFFFF';
    			}
    		}
    		
    	}
    	
    	// did they solve the puzzle?
		if (game.answerState.trim().toUpperCase() == game.answer.trim().toUpperCase())
		{
			setTimeout(function() {
				game.triggerGameEnd();
    		}, 2000);
			return false;
		}
    	
    	// are only vowels left? then play a sound  	
    	if (!game.onlyVowelsSoundPlayed && game.onlyVowelsLeft())
    	{
    		game.onlyVowelsSoundPlayed = true;
    		game.soundOnlyVowelsRemain.play();
    	}
    },
    
    clearBoard: function() {
    	// wipe the board to white
    	game.context.fillStyle = '#FFFFFF';
		game.context.fillRect(0, 0, 900, 400);
    }
};

$(document).ready(function() {
	
	game.init();
    
	//wheel init
	begin();
	
	$('a#quit-button').click(function(e) {
		e.preventDefault();
		$('#quitGameModal').modal();
	});
	
	$('button.spin-button').on('click', function() {
		if (game.currentMode == game.SpinBuySolve)
			game.spin();
	});
	
	$('button.buy-button').on('click', function() {
		if (game.currentMode == game.SpinBuySolve)
			game.buyVowel();
	});
	
	$('button.solve-button').on('click', function() {
		if (game.currentMode == game.SpinBuySolve)
		{
			game.currentMode = game.SolvePuzzle;
			
			//add answerState to the modal
			$('div#answerState').html(game.answerState.replace(/\*/g, '-').replace(/ /g, '<br>'));
			$('input#guess').val(game.answerState.replace(/\*/g, '-'));
			
			//show modal
	    	$('#solvePuzzleModal').modal();
		}
	});	
	
	$('#solvePuzzleModal').on('shown', function() {
		$('input#guess').focus();
	});
	
	$('#solvePuzzleModal').on('hidden', function() {
		//when modal closes attempt to solve the puzzle
		game.solvePuzzle();
	});
	
	$('button.consonant-button').on('click', function() {
		if (game.currentMode == game.PickConsonant)
			game.pickConsonant( $(this).data('letter') );
	});
	
	$('button.vowel-button').on('click', function() {
		if (! $(this).is(':disabled'))
			game.pickVowel( $(this).data('letter') );
	});	
	
	$('input#guess').keyup(function(){
	    this.value = this.value.toUpperCase();
	});
	
	 $('input#guess').keypress(function(event) {
        if (event.keyCode == 13) {
            $('#solvePuzzleModal').modal('hide');
        }
	 });
	 
	 $('body').keypress(function(event) {
		 game.routeKeyboardAction(event.keyCode);
	 });
});