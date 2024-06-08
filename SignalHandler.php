<?php

class SignalHandler {
    public static function initialize() {
        // Register signal handler
        pcntl_signal(SIGINT, [self::class, 'handleSignal']);
        // Enable signal dispatching
        pcntl_async_signals(TRUE);
    }

    public static function handleSignal($signo) {
        if ($signo === SIGINT) {
            self::exitProgram();
        }
    }

    public static function exitProgram() {
        system('stty -cbreak echo');
        echo "Exiting...\n";
        exit;
    }
}