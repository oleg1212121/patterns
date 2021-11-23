<?php
class Programmer
{
    public $a = 0;
    public $b = 0;

    public function setNumbers($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getSum()
    {
        return $this->a + $this->b;
    }
}

class Guy
{
    public $a = 0;
    public $b = 0;

    public function whatNumbersDude($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function iThinkSumIsIt()
    {
        return $this->a + $this->b;
    }
}

interface StandartInterface
{
    public function setNumbers($a, $b);
    public function getSum();
}

class ProgrammerAdapter implements StandartInterface
{
    public $human;
    public function __construct()
    {
        $this->human = new Programmer();
    }
    public function setNumbers($a, $b)
    {
        $this->human->setNumbers($a, $b);
    }
    public function getSum()
    {
        return $this->human->getSum();
    }
}


class GuyAdapter implements StandartInterface
{
    public $human;
    public function __construct()
    {
        $this->human = new Guy();
    }
    public function setNumbers($a, $b)
    {
        $this->human->whatNumbersDude($a, $b);
    }
    public function getSum()
    {
        return $this->human->iThinkSumIsIt();
    }
}

class Journalist
{
    public function askHumanAboutSum($a, $b, StandartInterface $human)
    {
        $human->setNumbers($a,$b);
        $class = get_class($human->human);
        $answer = $human->getSum();

        echo "{$class} answer {$a} + {$b} is : {$answer}";

        echo '<hr/>';
    }
}

$journalist = new Journalist();

$people = [
    new ProgrammerAdapter(),
    new GuyAdapter(),
    new ProgrammerAdapter(),
    new ProgrammerAdapter(),
    new GuyAdapter(),
    new ProgrammerAdapter(),
    new GuyAdapter(),
    new GuyAdapter(),
];

foreach ($people as $person) {
    $a = rand(1,500);
    $b = rand(1,500);
    $journalist->askHumanAboutSum($a, $b, $person);
}
