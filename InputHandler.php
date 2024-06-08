<?php
require_once __DIR__ . '/SignalHandler.php';
require_once __DIR__ . '/SnakeParameters.php';

class InputHandler {
    private $stdin;
    public $col;
    public $row;
    public $direction;

    public function __construct() {
        $this->col = SnakeParameters::STARTING_COL;
        $this->row = SnakeParameters::STARTING_ROW;
        $this->direction = 'RIGHT';
        $this->stdin = fopen('php://stdin', 'r');
        stream_set_blocking($this->stdin, 0);
        system('stty cbreak -echo');
    }

    public function readInput() {
        while (1) {
            $keypress = fgets($this->stdin);
            if ($keypress) {
                if ($keypress === "\e") {  // Check for ESC key
                    SignalHandler::exitProgram();
                }
                $this->clearScreen();
                $this->updatePosition();
                $this->printAtPosition($this->row, $this->col, 'o');
                echo 'Key pressed: ' . $this->translateKeypress($keypress) . ' Position: (' . $this->row . ', ' . $this->col . ')' . PHP_EOL;
            }
    
            // Dispatch signals
            pcntl_signal_dispatch();
        }
    }    

    private function translateKeypress($string) {
        switch ($string) {
            case "\033[A":
                $this->direction = 'UP';
                return "UP";
            case "\033[B":
                $this->direction = 'DOWN';
                return "DOWN";
            case "\033[C":
                $this->direction = 'RIGHT';
                return "RIGHT";
            case "\033[D":
                $this->direction = 'LEFT';
                return "LEFT";
            case "\n":
                return "ENTER";
            case " ":
                return "SPACE";
            case "\010":
            case "\177":
                return "BACKSPACE";
            case "\t":
                return "TAB";
            case "\e":
                return "ESC";
        }
        return $string;
    }
    

    private function updatePosition() {
        $this->row += SnakeParameters::DIRECTIONS[$this->direction][0];
        $this->col += SnakeParameters::DIRECTIONS[$this->direction][1];
    }

    private function clearScreen() {
        echo "\033[2J\033[H"; // Clear screen and move cursor to the top-left corner
    }
    
    private function printAtPosition($row, $col, $char) {
        echo "\033[{$row};{$col}H$char"; // Move cursor to ($row, $col) and print $char
    }
}