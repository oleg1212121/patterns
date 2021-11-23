<?php

class Character
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function display($size)
    {
        return $this->name . ' with size is' . $size;
    }
}

class FlyweightFactory
{
    public $stack = [];

    public function getCharacter($name)
    {
        if(!array_key_exists($name, $this->stack)){
            $this->stack[$name] = new Character($name);
        }

        return $this->stack[$name];
    }
}


$factory = new FlyweightFactory();
$string = 'AaaaaAvgFc';
echo $string . '<hr/>';


foreach (str_split($string) as $item) {
    echo $factory->getCharacter($item)->display(rand(1,10)) . '<hr/>';
}

echo 'Factory has only - '.count($factory->stack).' objects. <hr/>';
echo 'String has '. strlen($string) . ' characters';

