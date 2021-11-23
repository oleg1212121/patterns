<?php
/**
 *      Абстрактная фабрика
 * ---------------------------------
 * Порождающий шаблон проектирования
 *
 * Используется для создания семейств связанных объектов, не указывая их конкретных классов.
 * Абстрактная фабрика представляет собой интерфейс. Данный интерфейс реализуют конкретные фабрики.
 * Каждая конкретная фабрика с помощью методов может создать все необходимые объекты (конкретного типа фабрики).
 *
 * Недостаток - сложная структура и масштабируемость.
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Дополнительные классы для составления конкретной фабрики
// ==================================================================

class Property
{
    protected $field = '';

    public function __construct($field = null)
    {
        if ($field)
            $this->field = $field;
    }

    public function get()
    {
        return $this->field;
    }
}

class Color extends Property
{
    protected $field = 'white';
}

class Material extends Property
{
    protected $field = 'silk';
}

abstract class Thing
{
    protected $color;
    protected $material;

    public function __construct(Color $color, Material $material)
    {
        $this->color = $color->get();
        $this->material = $material->get();

    }

    public function getFields()
    {
        return "Color is {$this->color}, and material is {$this->material}";
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getMaterial()
    {
        return $this->material;
    }
    abstract function getDescription();
}

class Hat extends Thing
{
    public function getDescription()
    {
        $fields = static::getFields();
        return "</br>Hat fields is:</br>{$fields}";
    }
}

class Jacket extends Thing
{
    public function getDescription()
    {
        $fields = static::getFields();
        return "</br>Jacket fields is:</br>{$fields}";
    }
}

class Boots extends Thing
{
    public function getDescription()
    {
        $fields = static::getFields();
        return "</br>Boots fields is:</br>{$fields}";
    }
}

// ==================================================================
// ======= Классы людей
// ==================================================================

abstract class Human
{
    protected $goods = [];

    public function getGoods()
    {
        if(count($this->goods) > 0){
            foreach ($this->goods as $good) {
                echo $good->getDescription();
            }
        } else {
            echo 'Human is naked';
        }
    }
}

class HipsterBoy extends Human
{
    public function __construct()
    {
        $hat = new Hat(new Color('yellow'), new Material('silk'));
        $jacket = new Jacket(new Color('blue'), new Material('jeans'));
        $boots = new Boots(new Color('green'), new Material('leather'));
        array_push($this->goods, $hat);
        array_push($this->goods, $jacket);
        array_push($this->goods, $boots);
    }
}

class HipsterGirl extends Human
{
    public function __construct()
    {
        $hat = new Hat(new Color('yellow'), new Material('silk'));
        $jacket = new Jacket(new Color('blue'), new Material('jeans'));
        $boots = new Boots(new Color('green'), new Material('leather'));
        array_push($this->goods, $hat);
        array_push($this->goods, $jacket);
        array_push($this->goods, $boots);
    }
}

class Cowboy extends Human
{
    public function __construct()
    {
        $hat = new Hat(new Color('brown'), new Material('leather'));
        $jacket = new Jacket(new Color('brown'), new Material('leather'));
        $boots = new Boots(new Color('brown'), new Material('leather'));
        array_push($this->goods, $hat);
        array_push($this->goods, $jacket);
        array_push($this->goods, $boots);
    }
}

class Cowgirl extends Human
{
    public function __construct()
    {
        $hat = new Hat(new Color('brown'), new Material('leather'));
        $jacket = new Jacket(new Color('brown'), new Material('leather'));
        $boots = new Boots(new Color('brown'), new Material('leather'));
        array_push($this->goods, $hat);
        array_push($this->goods, $jacket);
        array_push($this->goods, $boots);
    }
}

class NakedBoy extends Human
{
}

class NakedGirl extends Human
{
}

// ==================================================================
// ======= Абстрактная фабрика человека
// ==================================================================

interface HumanAbstractFactoryInterface
{
    public function getBoy();
    public function getGirl();
}

// ==================================================================
// ======= Конкретные фабрики различных типов людей
// ==================================================================

class HipsersFactory implements HumanAbstractFactoryInterface
{
    public function getBoy()
    {
        return new HipsterBoy();
    }

    public function getGirl()
    {
        return new HipsterGirl();
    }
}

class CowherdsFactory implements HumanAbstractFactoryInterface
{
    public function getBoy()
    {
        return new Cowboy();
    }

    public function getGirl()
    {
        return new Cowgirl();
    }
}

class NakedsFactory implements HumanAbstractFactoryInterface
{
    public function getBoy()
    {
        return new NakedBoy();
    }

    public function getGirl()
    {
        return new NakedGirl();
    }
}

// ==================================================================
// Тесты
// ==================================================================
foreach (range(0, 8) as $item) {
    $randomFactory = rand(0,6);

    if($randomFactory == 0){
        $human = (new HipsersFactory())->getBoy();
    } else if ($randomFactory == 1){
        $human = (new HipsersFactory())->getGirl();
    } else if ($randomFactory == 2){
        $human = (new NakedsFactory())->getBoy();
    } else if ($randomFactory == 3){
        $human = (new NakedsFactory())->getGirl();
    } else if ($randomFactory == 4){
        $human = (new CowherdsFactory())->getBoy();
    } else {
        $human = (new CowherdsFactory())->getGirl();
    }
    $class = get_class($human);
    echo "<hr/>Human - {$class} ({$item}) fields:</br>";
    $human->getGoods();

}

