<?php

interface StrategyInterface
{
    public function createFile($name);
}

class CSV implements StrategyInterface
{
    public function createFile($name)
    {
        echo "Creating CSV file - {$name}.CSV <hr/>";
    }
}


class TXT implements StrategyInterface
{
    public function createFile($name)
    {
        echo "Creating TXT file - {$name}.TXT <hr/>";
    }
}

class HTML implements StrategyInterface
{
    public function createFile($name)
    {
        echo "Creating HTML file - {$name}.HTML <hr/>";
    }
}

class FileCreator
{
    protected $strategy;

    public function __construct(StrategyInterface $strategy)
    {
        $this->changeStrategy($strategy);
    }


    public function changeStrategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function create($name)
    {
        $this->strategy->createFile($name);
    }
}

$strategy_1 = new CSV();
$strategy_2 = new TXT();
$strategy_3 = new HTML();

$creator = new FileCreator($strategy_1);
$creator->create('Random_file_name');
$creator->changeStrategy($strategy_2);
$creator->create('Random_file_name_2');
$creator->changeStrategy($strategy_3);
$creator->create('Random_file_name_3');