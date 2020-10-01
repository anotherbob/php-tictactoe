<?php

	require_once('./TicTacToe/Game.php');
	require_once('./TicTacToe/ConsoleDisplay.php');

	$gameDisplay = new \TicTacToe\ConsoleDisplay;
	$game = new \TicTacToe\Game($gameDisplay);
	$game->play();