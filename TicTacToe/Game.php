<?php

namespace TicTacToe 
{
	class Game 
	{
		private $display = null;

		private $board = null;
		private $players = null;
		private $currentPlayer = null;
		private $playerScores = null;

		public function __construct($display) {
			$this->display = $display;

			$this->board = $this->resetBoard();
			$this->players = ['X', 'O'];
			$this->currentPlayer = 1;
			$this->playerScores = ['X' => 0, 'O' => 0];
		}
	
		public function play()
		{
			do {
				$this->showBoard();
				$this->currentPlayer = abs(--$this->currentPlayer);
	
				$result = [ 'valid' => false ];
				while (!$result['valid']) {
					$result = $this->requestCell();
				}
	
				if ($win = $this->checkWinner())
					$this->declareWin($win);
				else if ($this->boardFull())
					$this->declareTie();
			} while (true);
		}

		private function declareWin($win)
		{
			$winner = $win['player'];
			$this->playerScores[$winner]++;
			$this->drawWin($winner, $win['cells']);
			$this->printScore();
			$this->board = $this->resetBoard();
		}

		private function declareTie()
		{
			$this->display->declareTie();
			$this->printScore();
			$this->board = $this->resetBoard();
		}

		private function resetBoard()
		{
			return [['', '', ''], ['', '', ''], ['', '', '']];
		}

		private function drawWin($winner, $cells)
		{		
			$this->display->drawWin($this->board, $winner, $cells);
		}

		private function showBoard()
		{
			$this->display->showBoard($this->board);
		}

		private function requestCell()
		{
			$response = $this->display->prompt("Player {$this->players[$this->currentPlayer]}, please choose a square: ");
			
			if ($response === 'exit')
			{	
				$this->printFinalScore();
			}
			return $this->addResponse($this->players[$this->currentPlayer], $response);
		}

		private function addResponse($player, $response)
		{
			$response = (int)$response;
	
			if ($response < 1 || $response > 9) {
				$this->display->warning("Please enter a valid square");
				return [ 'valid' => false ];
			}
	
			$row = 0;
			$cell = 0;
			while ($response > 3) {
				$response -= 3;
				$row++;
			}

			while ($response > 1) {
				$response--;
				$cell++;
			}
	
			if ($this->board[$row][$cell] != '') {
				$this->display->warning("Your choice has already been taken");
				return [ 'valid' => false ];
			}
	
			$this->board[$row][$cell] = $player;
	
			return [ 'valid' => true ];
		}

		private function boardFull()
		{	
			foreach ($this->board as $row)
				foreach ($row as $cell)
					if ($cell == '')
						return false;

			return true;
		}

		private function checkWinner()
		{
			# test rows
			foreach ($this->board as $key => $row) {
				if ($test = $this->checkMatch($row[0], $row[1], $row[2]))
					return [ 'player' => test, 'cells' => [[$key, 0], [$key, 1], [$key, 2]] ];
			}

			# test columns
			for ($idx =0; $idx < 3; $idx++)
				if ($test = $this->checkMatch($this->board[0][$idx], $this->board[1][$idx], $this->board[2][$idx]))
					return [ 'player' => $test, 'cells' => [[0, $idx], [1, $idx], [2, $idx]] ];

			# test diagonal
			if ($test = $this->checkMatch($this->board[0][0], $this->board[1][1], $this->board[2][2]))
				return [ 'player' => $this->board[2][2], 'cells' => [[0, 0], [1, 1], [2, 2]] ];
	
			# test diagonal
			if ($test = $this->checkMatch($this->board[0][2], $this->board[1][1], $this->board[2][0]))
				return [ 'player' => $this->board[2][0], 'cells' => [[0, 2], [1, 1], [2, 0]] ];
	
			return false;
		}

		private function checkMatch($cell1, $cell2, $cell3)
		{

			if ($cell1 == $cell2 && $cell2 == $cell3 && $cell3 != '')
				return $cell3;
				
			return false;
		}

		private function printScore()
		{
			$this->display->printScore($this->players, $this->playerScores);
		}

		private function printFinalScore()
		{
			$this->display->printFinalScore($this->players, $this->playerScores);
		}
	}
}
