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

class HumanLook
{
    private $goods = [];

    public function __construct(Hat $hat, Jacket $jacket, Boots $boots)
    {
        array_push($this->goods, $hat->getDescription());
        array_push($this->goods, $jacket->getDescription());
        array_push($this->goods, $boots->getDescription());
    }

    public function getGoods()
    {
        foreach ($this->goods as $good) {
            echo $good . PHP_EOL;
        }
    }
}

$colors = [null, 'red', 'black', 'green', 'grey'];
$materials = [null, 'linen', 'coton', 'leather'];


foreach (range(0, 8) as $item) {

    $human = new HumanLook(
        new Hat(new Color($colors[array_rand($colors)]), new Material($materials[array_rand($materials)])),
        new Jacket(new Color($colors[array_rand($colors)]), new Material($materials[array_rand($materials)])),
        new Boots(new Color($colors[array_rand($colors)]), new Material($materials[array_rand($materials)]))
    );

    echo "<hr/>Human {$item} fields:</br>";
    $human->getGoods();

}

