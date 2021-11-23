<?php

class ChainCell
{
    protected $next = null;
    protected $name;
    
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setNext(ChainCell $cell)
    {
        $this->next = $cell;
    }

    public function writeMessage($value)
    {
        echo "This is {$this->name} <hr/>";
        if($value > rand(0,100)){
            echo "The {$this->name} is passed <hr/>";

            if($this->next){
                echo "The {$this->next->name} is next step <hr/>";
                $this->next->writeMessage($value);
            } else {
                echo "The {$this->name} is last part of chain, checking stopped <hr/>";
            }

        } else {
            echo "The {$this->name} is stopped :( <hr/>";
        }

    }
    
}

$cell_1 = new ChainCell('FIRST');
$cell_2 = new ChainCell('Second');
$cell_3 = new ChainCell('THIRD');

$cell_2->setNext($cell_3);
$cell_1->setNext($cell_2);

$cell_1->writeMessage(55);
