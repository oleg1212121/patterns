<?php
/**
 *            ПРОТОТИП
 * ---------------------------------
 * Порождающий шаблон проектирования
 *
 * Позволяет копировать объекты не вдаваясь в подробности реализации.
 * Для реализации используется метод clone.
 * Для реализации с сложными объектами нужно использовать более сложную реализацию с описанием клонирования всех частей.
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Вспомогательные классы для составного объекта
// ==================================================================

class Field
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

class Color extends Field
{
    protected $field = 'white';
}

class Material extends Field
{
    protected $field = 'silk';
}

// ==================================================================
// ======= Классы которые будут клонироваться
// ==================================================================

abstract class Thing
{
    protected $color;
    protected $material;

    public function __construct(Color $color, Material $material)
    {
        $this->color = $color;
        $this->material = $material;
    }

    public function getFields()
    {
        return "Color is {$this->color->get()}, and material is {$this->material->get()}";
    }

    public function setColor(Color $color)
    {
        $this->color = $color;
    }

    public function setMaterial(Material $material)
    {
        $this->material = $material;
    }

    // реализация клонирования вложенных объектов
    public function __clone()
    {
        $this->color = clone $this->color;
        $this->material = clone $this->material;
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

// ==================================================================
// ======= Класс производитель прототипов
// ==================================================================

class Market
{
    protected $hat;
    protected $jacket;

    public function __construct(Hat $hat , Jacket $jacket)
    {
        $this->hat = $hat;
        $this->jacket = $jacket;
    }

    public function getHat()
    {
        return clone $this->hat;
    }

    public function getJacket()
    {
        return clone $this->jacket;
    }
}

// ==================================================================
// Тесты
// ==================================================================

$materials = [null, 'linen', 'coton', 'leather'];
$market = new Market(
    new Hat(new Color('green'), new Material($materials[array_rand($materials)])),
    new Jacket(new Color('green'), new Material($materials[array_rand($materials)]))
);
$hat_1 = $market->getHat();
$hat_2 = $market->getHat();
echo 'First ' . $hat_1->getDescription() . '<hr/>';
echo 'Second ' . $hat_2->getDescription() . '<hr/>';
echo 'Changing color on hat_1 ... <hr/>';
$hat_1->setColor(new Color('GreyLight'));
echo 'First ' . $hat_1->getDescription() . '<hr/>';
echo 'Second ' . $hat_2->getDescription() . '<hr/>';