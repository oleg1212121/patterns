<?php
/**
 *            НАБЛЮДАТЕЛЬ
 * ---------------------------------
 * Поведенческий шаблон проектирования
 *
 * Позволяет организовать механизм подписки некоторых объектов на некоторые действия других объектов.
 * Благодаря реализуемому интерфейсу наблюдателей, инициатор не заботится о самой логике оповещений.
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Классы наблюдатели
// ==================================================================

interface Observable
{
    public function notify();
}

abstract class AbstractObserver implements Observable
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function notify()
    {
        $class = get_class($this);
        echo "{$class} received a message  <hr/>";
    }
}

class User extends AbstractObserver
{

}

class Alien extends AbstractObserver
{

}

// ==================================================================
// ======= Класс за которым наблюдают
// ==================================================================

class Initiator
{
    private $observers = [];
    private $data = 'some data for example';

    public function subscribe(AbstractObserver $observer)
    {
        $this->observers[$observer->name] = $observer;
    }

    public function unSubscribe(AbstractObserver $observer)
    {
        unset($this->observers[$observer->name]);
    }

    public function changeData($newData)
    {
        $this->data = $newData;
        echo "{$newData} - is a new DATA  <hr/>";
        $this->sendNotices();
    }

    private function sendNotices()
    {
        foreach ($this->observers as $observer) {
            $observer->notify();
        }
    }
}

// ==================================================================
// Тесты
// ==================================================================

$initiator = new Initiator();
$user_1 = new User('OLEG');
$user_2 = new User('MARINA');
$user_3 = new Alien('a-=0adsa9==asdk;lm');
$initiator->subscribe($user_1);
$initiator->subscribe($user_2);
$initiator->subscribe($user_3);
$initiator->changeData('NEW DATA !!! YESSS !!');
$initiator->unSubscribe($user_2);
$initiator->changeData('PARLEZ VOUS FRANCAIS ??? OUI !!');