<?php

namespace TicTacToe
{
	class ConsoleDisplay
	{
		public function printScore($players, $playerScores)
		{
			echo "\n\nCurrent Score:\n";
			foreach ($players as $player) {
				echo "\tPlayer ${player} has won ${playerScores[$player]} games.\n";
			}
			echo "\n------------------------\n\nStarting next match\n";
		}

		public function printFinalScore($players, $playerScores)
		{
			echo "\n\nFinal Score:";
			foreach ($players as $player) {
				echo "Player ${player} has won {$playerScores[$player]} games.\n";
			}
			echo "\n------------------------\n\nThank you for playing!\n";
		}

		public function warning($warning)
		{
			echo "warning: $warning\n";
		}

		public function showBoard($board)
		{
			$idx = 0;

			foreach ($board as $row) {
				echo "\n-------------\n|";
				foreach ($row as $cell) {
					$idx++;
					if ($cell === '')
						echo " ${idx} |";
					else
						echo " ${cell} |";
				}
			}

			echo "\n-------------\n";
		}

		public function drawWin($board, $winner, $cells)
		{
			echo "\nPlayer ${winner} has won this match!\n";

			foreach ($board as $idx => $row)
			{
				print "\n-------------\n|";
				foreach ($row as $iidx => $cell)
				{
					if (in_array([$idx, $iidx], $cells))
						echo " ${cell} |";
					else
						echo "   |";
				}
			}
			echo "\n-------------";
		}

		public function declareTie()
		{
			echo "\nNeither player won this match.\n";
			echo "\nStarting next match.\n";
		}

		public function prompt($request)
		{
			echo "${request}\nOr type 'exit' to end the game.\n";

			$value = null;

			try
			{
				$value = readline();
			}
			catch (Exception $e)
			{
				echo "ERROR: No mechanism for accepting input.\n";
			}

			return $value;
		}
	}
}