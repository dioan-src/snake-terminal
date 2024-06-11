<?php
require_once __DIR__ . '/Inputs.php';
require_once __DIR__ . '/TerminalHandler.php';
const SLEEPYTIME = 200000;

// Get terminal dimensions
$terminalWidth = TerminalHandler::getTerminalWidth();
$terminalHeight = TerminalHandler::getTerminalHeight();
$game = new Game($terminalHeight, $terminalWidth);

$stdin = fopen('php://stdin', 'r');
stream_set_blocking($stdin, 0);
system('stty cbreak -echo');

while (1) {
    // Listen for keypresses
    $keypress = fgets($stdin);
    if ($keypress) {
        $keypress = Inputs::translateKeypress($keypress);

        if(in_array($keypress,[Directions::UP, Directions::DOWN, Directions::LEFT, Directions::RIGHT])){
            $game->getSnake()->changeDirection($keypress);
        }else if($keypress == 'ESC'){
            break;
        }
    }
    $game->makeMove();

    TerminalHandler::OutputBoard($game);
    if ($game->getHealth() == false) break;
    usleep(SLEEPYTIME);
}

TerminalHandler::showGameOverScreen();
TerminalHandler::resetTerminalSettings();
TerminalHandler::moveCursorAndDisplayText(1, 1, 'Score : ' . $game->getScore());