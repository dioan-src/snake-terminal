<?php
require_once __DIR__ . '/Game.php';
require_once __DIR__ . '/Directions.php';
require_once __DIR__ . '/TerminalScreens.php';

const HEAD_ICON = [
    Directions::UP => '^',
    Directions::DOWN => 'v',
    Directions::LEFT => '<',
    Directions::RIGHT => '>',
];

class TerminalHandler {
    public static function OutputBoard(Game $game): void{
        self::clearScreen();
        self::hideCursor();
        $body = $game->getSnake()->getBody();
        $food = $game->getFood();
        foreach($body as $key => $part){
            if(isset($body[$key+1])){ self::moveCursorAndDisplayText($part[0], $part[1], 'o'); }
            else{self::moveCursorAndDisplayText($part[0], $part[1], HEAD_ICON[$game->getSnake()->getDirection()]);}
        }
        self::moveCursorAndDisplayText($food[0], $food[1], 'x');
    }

    // Clear the screen
    public static function clearScreen(): void
    {
        system('clear');
    }

    // Hide the cursor
    public static function hideCursor(): void
    {
        echo "\e[?25l";
        flush();
    }

    // Show the cursor
    public static function showCursor(): void
    {
        echo "\e[?25h";
        flush();
    }

    // Get terminal width
    public static function getTerminalWidth(): int{
        return (int) exec('tput cols');
    }

    // Get terminal height
    public static function getTerminalHeight(): int{
        return (int) exec('tput lines');
    }

    // Move cursor to a specific position and display text
    public static function moveCursorAndDisplayText($row, $column, $text): void
    {
        echo "\e[{$row};{$column}H{$text}";
        flush();
    }

    public static function showTerminalInput(): void
    {
        shell_exec('stty sane');
    }

    public static function resetTerminalSettings(): void
    {
        self::clearScreen();
        self::showCursor();
        self::showTerminalInput();
    }

    public static function showGameOverScreen(): void
    {
        self::hideCursor();
        // Convert the multiline string to an array of lines
        $lines = explode("\n", TerminalScreens::GAME_OVER_SCREEN);

        // Number of lines to initially show
        $visibleLines = 13;
        $totalLines = count($lines);
        
        for ($i = 0; $i < $totalLines - $visibleLines; $i++) {
            self::clearScreen();
            $cnt = 1;
            for ($j = $i; $j < $i + $visibleLines; $j++) {
                if (isset($lines[$j])) {
                    self::moveCursorAndDisplayText($cnt,1, $lines[$j]);
                }
                $cnt++;
            }
            usleep(200000);
        }
        usleep(200000);
    }
}