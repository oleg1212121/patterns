<?php
/**
 *           СТРОИТЕЛЬ
 * ---------------------------------
 * Порождающий шаблон проектирования
 *
 * Используется как интерфейс для пошагового заполнения/изменения объекта-продукта.
 *
 * Директор - принимает объект строителя. Методы директора содержат заранее определенный набор вызовов методов строителя.
 * Таким образом директор может создавать продукты с различным набором частей.
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Классы частей из которых собирается продукт
// ==================================================================

abstract class ProductPart
{
    public $name;

    public function getInfo()
    {
        return $this->name;
    }
}

class USB_C extends ProductPart
{
    public $name = 'USB_C';
}

class USB_A extends ProductPart
{
    public $name = 'USB_A';
}

class USB_B extends ProductPart
{
    public $name = 'USB_B';
}

class HDMI extends ProductPart
{
    public $name = 'HDMI';
}

class DVI extends ProductPart
{
    public $name = 'DVI';
}

// ==================================================================
// ======= Класс продукта который будет собираться строителем
// ==================================================================

class Product
{
    public $parts = [];

    public function getDescription()
    {
        foreach ($this->parts as $part) {
            echo $part->getinfo() . '<hr/>';
        }
    }
}

// ==================================================================
// ======= Строитель
// ==================================================================

interface BuilderInterface
{
    public function installUSB_A();
    public function installUSB_B();
    public function installUSB_C();
    public function installHDMI();
    public function installDVI();
    public function getProduct();
}

class NotebookPortsAdapterBuilder implements BuilderInterface
{
    protected $product;
    
    public function __construct()
    {
        $this->resetProduct();
    }

    protected function resetProduct()
    {
        $this->product = new Product();
    }

    public function installUSB_A()
    {
        array_push($this->product->parts, new USB_A());
    }

    public function installUSB_B()
    {
        array_push($this->product->parts, new USB_B());
    }

    public function installUSB_C()
    {
        array_push($this->product->parts, new USB_C());
    }

    public function installHDMI()
    {
        array_push($this->product->parts, new HDMI());
    }

    public function installDVI()
    {
        array_push($this->product->parts, new DVI());
    }

    public function getProduct()
    {
        $this->product->getDescription();
        $this->resetProduct();
    }
}

// ==================================================================
// ======= Директор
// ==================================================================

class NotebookPortsAdapterDirector
{
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function createFullPackageAdapter()
    {
        $this->builder->installUSB_A();
        $this->builder->installUSB_B();
        $this->builder->installUSB_C();
        $this->builder->installHDMI();
        $this->builder->installDVI();
        $this->builder->getProduct();
    }

    public function createMinimalAdapter()
    {
        $this->builder->installUSB_A();
        $this->builder->installHDMI();
        $this->builder->getProduct();
    }

    public function createDefaultAdapter()
    {
        $this->builder->installUSB_C();
        $this->builder->installHDMI();
        $this->builder->installDVI();
        $this->builder->getProduct();
    }
}

// ==================================================================
// Тесты
// ==================================================================

$builder = new NotebookPortsAdapterBuilder();
$director = new NotebookPortsAdapterDirector($builder);
$director->createFullPackageAdapter();
echo "=================================<hr/>";
$director->createDefaultAdapter();
