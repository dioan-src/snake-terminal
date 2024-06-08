<?php
require_once __DIR__ . '/SignalHandler.php';

class InputHandler {
    private $stdin;

    public function __construct() {
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
                echo 'Key pressed: ' . $this->translateKeypress($keypress) . PHP_EOL;
            }

            // Dispatch signals
            pcntl_signal_dispatch();
        }
    }

    private function translateKeypress($string) {
        switch ($string) {
            case "\033[A":
                return "UP";
            case "\033[B":
                return "DOWN";
            case "\033[C":
                return "RIGHT";
            case "\033[D":
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
}