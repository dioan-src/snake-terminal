<?php 
require_once __DIR__ . '/Directions.php';
require_once __DIR__ . '/SnakeParameters.php';

class Snake {
    private array $body;
    private string $direction;

    public function __construct(array $seed = null, string $direction = Directions::RIGHT)
    {
        if ($seed) $this->body[] = $seed;
        else $this->body[] = [SnakeParameters::STARTING_ROW, SnakeParameters::STARTING_COL];
        $this->direction = $direction;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function changeDirection(string $direction): void
    {
        if (Directions::isLegalMove($this->direction, $direction)) {
            $this->direction = $direction;
        }
    }

    public function move(bool $eat = false): void
    {
        $nextPosition = $this->calculateNextMove();
        //insert on body
        array_push($this->body, $nextPosition);
        //only keep first position if snake ate
        if ($eat == false) array_shift($this->body);
    }

    public function calculateNextMove(): array
    {
        //get head position
        $head = end($this->body);
        //figure out next position based on head position + direction
        $nextPosition = [
            $head[0] + SnakeParameters::DIRECTIONS[$this->direction][0],
            $head[1] + SnakeParameters::DIRECTIONS[$this->direction][1]
        ];

        return $nextPosition;
    }

    public function hitObstacle(int $row, int $col): bool
    {
        return in_array([$row, $col], $this->body);
    }
}
