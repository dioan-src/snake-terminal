<?php
require_once __DIR__ . '/Snake.php';
require_once __DIR__ . '/Directions.php';

class Game {
    private ?array $food = null;
    private Snake $snake;
    private int $length;
    private int $height;
    private bool $health = true;
    private float $score = 0;
    private $foodSetAt;

    private const TIME_LIMIT = 20;

    public function __construct(int $height, int $length, array $snakeSeed = null, array $food = null)
    {
        $this->length = $length;
        $this->height = $height;
        
        if ($snakeSeed){ $this->snake = new Snake($snakeSeed);}
        else{ $this->snake = new Snake();}

        if ($food){ $this->food = $food;}
        else{ $this->generateFoodPosition();}
    }

    public function getFood(): array
    {
        return $this->food;
    }

    public function getSnake(): Snake
    {
        return $this->snake;
    }

    public function getHealth(): bool
    {
        return $this->health;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function generateFoodPosition(): void
    {
        while(true) {
            $row = rand(1,$this->height);
            $col = rand(1,$this->length);

            if (
                !in_array([$row, $col], $this->snake->getBody())
                && [$row, $col] != $this->food) break;
        }
        $this->food = [$row, $col];
        $this->foodSetAt = microtime(true);
    }

    public function makeMove(): void
    {
        $next = $this->snake->calculateNextMove();
        if (
            ($this->validateBoundaries($next[0], $next[1]) == false)
            || ($this->snake->hitObstacle($next[0], $next[1]))
        ) {
            $this->health = false;
        }
        $eats = ([$next[0], $next[1]] == $this->food);
        $this->snake->move( $eats );
        if ($eats) {
            $this->generateFoodPosition();
            $this->addScore();
        }
    }

    public function validateBoundaries(int $row, int $col)
    {
        return ($row >= 0 && $row < $this->height) &&
            ($col >= 0 && $col < $this->length);
    }

    public function addScore()
    {
        // echo $this->foodSetAt . PHP_EOL;
        // $timeDifference = microtime(true) - $this->foodSetAt;
        // $timeDifference = number_format($timeDifference, 2);
        // die($timeDifference);
        $timeDifference = 10;
        if ($timeDifference > 20) {
            $score = 0;
        } else {
            // Calculate points based on how close the time taken is to 0 seconds
            $points = (20 - $timeDifference) / 20 * 100;
            $score = round($points);
        }
        
        $this->score = $this->score + $score; 
    }
}