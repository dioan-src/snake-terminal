<?php
class SnakeParameters {
    const STARTING_ROW = 5;
    const STARTING_COL = 5;
    const STARTING_DIRECTION = 'RIGHT';
    const DIRECTIONS = [
        'RIGHT' => [0,+1],
        'DOWN' => [+1,0],
        'LEFT' => [0,-1],
        'UP' => [-1,0]
    ];
}