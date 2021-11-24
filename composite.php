<?php
/**
 *             КОМПОНОВЩИК
 * ---------------------------------
 * Структурный шаблон проектирования
 *
 * Позволяет сгруппировать древовидные структуры объектов и групп объектов, но работать с ними как с одним объектом.
 * Должен быть реализован интерфейс, позволяющий рекурсивно обойти все вложенные объекты и получить результат.
 *
 * Пример - корзина продуктов и коробок с продуктами.
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Класс компоновщика
// ==================================================================

interface CompositeLeafInterface
{
    public function display();
}

class Composite implements CompositeLeafInterface
{
    protected $childs = [];
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function add(CompositeLeafInterface $item)
    {
        $this->childs[$item->name] = $item;
    }


    public function remove(CompositeLeafInterface $item)
    {
        unset($this->childs[$item->name]);
    }

    public function display()
    {
        echo "This is {$this->name}<hr/>";
        foreach ($this->childs as $item){
            $item->display();
        }
    }
}

// ==================================================================
// ======= Класс отдельного объекта
// ==================================================================

class Leaf implements CompositeLeafInterface
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
    public function display()
    {
        echo $this->name . '<hr/>';
    }
}

// ==================================================================
// Тесты
// ==================================================================

$rootComposite = new Composite('ROOT COMPOSITE');
$leafComposite = new Composite('LEAF COMPOSITE');
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