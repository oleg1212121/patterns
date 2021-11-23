<?php

class User
{
    private $state = null;

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function saveMemento()
    {
        return new Memento($this->state);
    }

    public function restoreMemento(Memento $memento)
    {
        $this->state = $memento->getState();
    }
}

class Memento
{
    private $state;
    public function __construct($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }
}

class Receiver
{
    private $memento;

    public function saveMemento(Memento $memento)
    {
        $this->memento = $memento;
    }

    public function getMemento()
    {
        return $this->memento;
    }
}

$user = new User();
echo "current state is - ' {$user->getState()} ' <hr/>";
$user->setState('first state');

echo "current state is - {$user->getState()} <hr/>";
$receiver = new Receiver();
$receiver->saveMemento($user->saveMemento());
$user->setState('NEW STATE');

echo "current state is - {$user->getState()} <hr/>";

$user->restoreMemento($receiver->getMemento());


echo "current state is - {$user->getState()} <hr/>";