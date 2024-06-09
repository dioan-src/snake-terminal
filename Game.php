<?php
require_once __DIR__ . '/Snake.php';
require_once __DIR__ . '/Directions.php';

class Game {
    private ?array $food = null;
    private Snake $snake;
    private int $length;
    private int $height;
    private bool $health = true;

    public function __construct(int $height, int $length, array $snakeSeed = null, array $food = null)
    {
        $this->length = $length;
        $this->height = $height;

        if ($snakeSeed) $this->snake = new Snake($snakeSeed);
        else $this->snake = new Snake();

        if ($food) $this->food = $food;
        else $this->food = $this->generateFoodPosition();
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
    }

    public function makeMove(): bool
    {
        $next = $this->snake->calculateNextMove();
        if (
            ($this->validateBoundaries($next[0], $next[1]) == false)
            || ($this->snake->hitObstacle($next[0], $next[1]))
        ) {
            $this->health = false;
            return false;
        }
        $eats = ([$next[0], $next[1]] == $this->food);
        $this->snake->move( $eats );
        if ($eats) $this->generateFoodPosition();
        return true;
    }

    public function validateBoundaries(int $row, int $col)
    {
        return ($row >= 0 && $row < $this->height) &&
            ($col >= 0 && $col < $this->length);
    }
}

// $game = new Game(height:10, length:10, food:[7,8]);
// var_dump($game);
// var_dump($game->getSnake()->getBody());
// echo PHP_EOL . ' ----------  ';
// echo $game->makeMove() ? 'ye':'ne';
// echo ' ----------  ' . PHP_EOL;
// var_dump($game->getSnake()->getBody());
// echo PHP_EOL . ' ----------  ';
// echo $game->makeMove() ? 'ye':'ne';
// echo ' ----------  ' . PHP_EOL;
// var_dump($game->getSnake()->getBody());
// echo PHP_EOL . ' ----------  ';
// echo $game->makeMove() ? 'ye':'ne';
// echo ' ----------  ' . PHP_EOL;
// var_dump($game->getSnake()->getBody());
// $game->getSnake()->changeDirection(Directions::DOWN);
// echo PHP_EOL . ' ----------  ';
// echo $game->makeMove() ? 'ye':'ne';
// echo ' ----------  ' . PHP_EOL;
// var_dump($game->getSnake()->getBody());
// echo PHP_EOL . ' ----------  ';
// echo $game->makeMove() ? 'ye':'ne';
// echo ' ----------  ' . PHP_EOL;
// var_dump($game->getSnake()->getBody());
// var_dump($game->getFood());
// $game->getSnake()->changeDirection(Directions::RIGHT);
// echo PHP_EOL . ' ----------  ';
// echo $game->makeMove() ? 'ye':'ne';
// echo ' ----------  ' . PHP_EOL;
// var_dump($game->getSnake()->getBody());
// var_dump($game->getFood());