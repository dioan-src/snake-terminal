<?php
require_once __DIR__ . '/SignalHandler.php';
require_once __DIR__ . '/InputHandler.php';

// Initialize signal handler
SignalHandler::initialize();

// Handle user input
$inputHandler = new InputHandler();
$inputHandler->readInput();