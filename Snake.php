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

    public function changeDirection(string $direction): void
    {
        if (Directions::isLegalMove($this->direction, $direction)) {
            $this->direction = $direction;
            echo PHP_EOL . '---------  changed to '.$this->direction.' ---------' . PHP_EOL . PHP_EOL;
        }else{
            echo PHP_EOL . '---------  still '.$this->direction.' ---------' . PHP_EOL . PHP_EOL;
        }
    }

    public function move(bool $eat = false): void
    {
        //get head position
        $head = end($this->body);
        //figure out next position based on head position + direction
        $nextPosition = [
            $head[0] + SnakeParameters::DIRECTIONS[$this->direction][0],
            $head[1] + SnakeParameters::DIRECTIONS[$this->direction][1]
        ];
        //insert on body
        array_push($this->body, $nextPosition);
        //only keep first position if snake ate
        if ($eat == false) array_shift($this->body);
    }
}

$snek = new Snake(seed:[1,4], direction:Directions::DOWN);
var_dump($snek);
$snek->move();
var_dump($snek);
$snek->move();
var_dump($snek);
$snek->changeDirection(Directions::RIGHT);
$snek->move();
var_dump($snek);
$snek->changeDirection(Directions::RIGHT);
$snek->move();
var_dump($snek);
$snek->changeDirection(Directions::LEFT);
$snek->move();
var_dump($snek);
$snek->changeDirection(Directions::UP);
$snek->move(true);
var_dump($snek);
$snek->changeDirection(Directions::DOWN);
$snek->move();
var_dump($snek);
