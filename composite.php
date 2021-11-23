<?php

abstract class AbstractComposite
{
    protected $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    abstract function display();
}

class Composite extends AbstractComposite
{
    protected $childs = [];

    public function add(AbstractComposite $item)
    {
        $this->childs[$item->name] = $item;
    }


    public function remove(AbstractComposite $item)
    {
        unset($this->childs[$item->name]);
    }

    public function display()
    {
        foreach ($this->childs as $item){
            $item->display();
        }
    }
}

class Leaf extends AbstractComposite
{
    public function display()
    {
        echo $this->name;
        echo '<hr/>';
    }
}


$rootComposite = new Composite('ROOT');

$leafComposite = new Composite('LEAF');

$leaf_1 = new Leaf('leaf_1');
$leaf_2 = new Leaf('leaf_2');
$leaf_3 = new Leaf('leaf_3');
$leaf_4 = new Leaf('leaf_4');
$leaf_5 = new Leaf('leaf_5');
$leaf_6 = new Leaf('leaf_6');

$rootComposite->add($leaf_1);
$rootComposite->add($leaf_6);
$leafComposite->add($leaf_2);
$leafComposite->add($leaf_3);
$leafComposite->add($leaf_4);
$leafComposite->add($leaf_5);
$rootComposite->add($leafComposite);

$rootComposite->display();