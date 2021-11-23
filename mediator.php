<?php

abstract class Human
{
    protected $mediator;
    public $name;

    public function __construct($mediator, $name)
    {

        $this->mediator = $mediator;
        $this->name = $name;
        $this->mediator->init($this);
    }

    public function message($message)
    {
        echo "{$this->name} says {$message} <hr/>";
        $this->mediator->message($this, $message);
    }

    public function notify()
    {
        $class = get_class($this);
        echo "{$this->name} is {$class} has receive a message!!!<hr/>";
    }
}

class User extends Human
{

}

class Admin extends Human
{

}

class Mediator
{
    protected $humans = [];

    public function init(Human $human)
    {
        $this->humans[$human->name] = $human;
    }

    public function message(Human $human, $message)
    {
        foreach ($this->humans as $k => $item) {
            if($k !== $human->name){
                $item->notify();
            }
        }
    }
}

$mediator = new Mediator();
$human_1 = new User($mediator, 'Vasya');
$human_2 = new Admin($mediator, 'Kolia');
$human_3 = new User($mediator, 'Jenia');

$human_1->message('HELLO GUYS');
$human_2->message('HELLO >.<');