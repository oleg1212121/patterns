<?php
/**
 *            ОДИНОЧКА
 * ---------------------------------
 * Порождающий шаблон проектирования
 *
 * Позволяет гарантировать, что существует единственный объект класса-одиночки.
 * Применяется в случаях когда нет необходимости создания множества объектов некоего класса (например подключение к БД)
 *
 */

// ==================================================================
// Структура
// ==================================================================

trait Singleton {
    private static $instance = null;
    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    public static function getInstance()
    {
        if(!static::$instance){
            static::$instance = new static();
        }
        return static::$instance;
    }
}

class SingletonClass
{
    use Singleton;
    public $field = 123;

    public function setField($value)
    {
        $this->field = $value;
    }

    public function getField()
    {
        return $this->field;
    }
}

// ==================================================================
// Тесты
// ==================================================================

$obj = SingletonClass::getInstance();
echo $obj->getField() . 'Получили поле первого объекта <hr/>';
echo $obj->setField(55555);
echo $obj->getField() . 'Изменили поле первого объекта и получили его<hr/>';
$obj2 = SingletonClass::getInstance();
echo $obj2->getField() . 'Создали еще объект и получили его поле, но объект оказался таким же как и первый<hr/>';
echo $obj->setField(33333);
echo $obj2->getField() . 'Поменяли поле у первого объекта и получили поле у второго объекта (совпадают т.к. это один и тот же объект)<hr/>';
echo $obj2->setField(1111);
echo $obj->getField() . 'Изменили поле у второго объекта и получили поле первого и они опять совпадают<hr/>';
echo ($obj === $obj2) . ' - обе переменные ссылаются на один объект';