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

class Human
{
    protected $hat;
    protected $jacket;
    protected $boots;

    public function setGoods(Hat $hat = null, Jacket $jacket = null, Boots $boots = null)
    {
        $this->setHat($hat);
        $this->setJacket($jacket);
        $this->setBoots($boots);
    }

    public function setHat(Hat $hat)
    {
        $this->hat = $hat;
    }

    public function setJacket(Jacket $jacket)
    {
        $this->jacket = $jacket;
    }
    public function setBoots(Boots $boots)
    {
        $this->boots = $boots;
    }

    public function getHat()
    {
        return $this->hat;
    }

    public function getJacket()
    {
        return $this->jacket;
    }

    public function getBoots()
    {
        return $this->boots;
    }

    public function getGoods()
    {
        $fields = [
            $this->hat,
            $this->jacket,
            $this->boots,
        ];
        foreach ($fields as $item) {
            if($item) echo $item->getDescription();
        }
    }
}

abstract class HumanBuilder
{
    protected $human;

    public function createHuman()
    {
        $this->human = new Human();
    }
    public function getHuman()
    {
        return $this->human;
    }

    abstract function buildHat();
    abstract function buildJacket();
    abstract function buildBoots();

}

class YellowLeatherHumanBuilder extends HumanBuilder
{
    public function buildHat()
    {
        $this->human->setHat(new Hat(new Color('yellow'), new Material('leather')));
    }

    public function buildJacket()
    {
        $this->human->setJacket(new Jacket(new Color('yellow'), new Material('leather')));
    }

    public function buildBoots()
    {
        $this->human->setBoots(new Boots(new Color('yellow'), new Material('leather')));
    }
}


class GreenCotonHumanBuilder extends HumanBuilder
{
    public function buildHat()
    {
        $this->human->setHat(new Hat(new Color('green'), new Material('coton')));
    }

    public function buildJacket()
    {
        $this->human->setJacket(new Jacket(new Color('green'), new Material('coton')));
    }

    public function buildBoots()
    {
        $this->human->setBoots(new Boots(new Color('green'), new Material('coton')));
    }
}

class Director
{
    protected $builder;

    public function setBuilder(HumanBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function getHuman()
    {
        if($this->builder){
            $this->builder->createHuman();
            $this->builder->buildHat();
            $this->builder->buildJacket();
            $this->builder->buildBoots();
            return $this->builder->getHuman();
        } else {
            return null;
        }
    }
}

$director = new Director();
$builder_1 = new YellowLeatherHumanBuilder();
$builder_2 = new GreenCotonHumanBuilder();

$director->setBuilder($builder_1);
$human = $director->getHuman();
$human->getGoods();
echo '<hr/>';
$director->setBuilder($builder_2);
$human = $director->getHuman();
$human->getGoods();
