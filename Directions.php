<?php
class Directions {
    const RIGHT = 'RIGHT';
    const DOWN = 'DOWN';
    const LEFT = 'LEFT';
    const UP = 'UP';

    public static function isLegalMove(string $originalDirection, string $nextDirection): bool{
        if ( in_array($originalDirection, [self::UP, self::DOWN]) 
        && in_array($nextDirection, [self::UP, self::DOWN]) ) {return false;}

        if ( in_array($originalDirection, [self::LEFT, self::RIGHT]) 
        && in_array($nextDirection, [self::LEFT, self::RIGHT]) ) {return false;}
    
        return true;
    }
}