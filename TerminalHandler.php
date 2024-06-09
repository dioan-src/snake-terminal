<?php
require_once __DIR__ . '/Game.php';

class TerminalHandler {
    public static function OutputBoard(Game $game): void{
        self::clearScreen();
        self::hideCursor();
        $body = $game->getSnake()->getBody();
        $food = $game->getFood();
        foreach($body as $part){
            self::moveCursorAndDisplayText($part[0], $part[1], 'o');
        }
        self::moveCursorAndDisplayText($food[0], $food[1], '*');
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


}