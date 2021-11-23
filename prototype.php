<?php

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


abstract class Market
{
    protected $hat;
    protected $jacket;
    protected $boots;

    public function __construct(Hat $hat , Jacket $jacket , Boots $boots )
    {
        $this->hat = $hat;
        $this->jacket = $jacket;
        $this->boots = $boots;
    }

    public function getHat()
    {
        return clone $this->hat;
    }

    public function getJacket()
    {
        return clone $this->jacket;
    }

    public function getBoots()
    {
        return clone $this->boots;
    }
}

class GreenMarket extends Market
{

}

class RedMarket extends Market
{

}

$materials = [null, 'linen', 'coton', 'leather'];

$greenMarket = new GreenMarket(
    new Hat(new Color('green'), new Material($materials[array_rand($materials)])),
    new Jacket(new Color('green'), new Material($materials[array_rand($materials)])),
    new Boots(new Color('green'), new Material($materials[array_rand($materials)]))
);


$redMarket = new RedMarket(
    new Hat(new Color('red'), new Material($materials[array_rand($materials)])),
    new Jacket(new Color('red'), new Material($materials[array_rand($materials)])),
    new Boots(new Color('red'), new Material($materials[array_rand($materials)]))
);

echo $greenMarket->getHat()->getDescription();
echo '<hr/>';

echo $greenMarket->getJacket()->getDescription();
echo '<hr/>';

echo $greenMarket->getBoots()->getDescription();
echo '<hr/>';

echo $redMarket->getJacket()->getDescription();
echo '<hr/>';

echo $redMarket->getBoots()->getDescription();