<?php
/**
 *            СНИМОК
 * ---------------------------------
 * Поведенческий шаблон проектирования
 *
 * Позволяет сохранять и восстанавливать прошлые состояния объектов (снимки).
 * Снимки можно складывать в объект-хранитель, чтобы в дальнейшем можно было их восстанавливать.
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Класс состояния (помимо $state можно сохранять сам объект)
// ==================================================================

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

// ==================================================================
// ======= Класс снимка
// ==================================================================

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

// ==================================================================
// ======= Класс хранилища
// ==================================================================

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

// ==================================================================
// Тесты
// ==================================================================

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