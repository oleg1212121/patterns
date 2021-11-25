<?php
/**
 *            ЗАМЕСТИТЕЛЬ
 * ---------------------------------
 * Структурный шаблон проектирования
 *
 * Создает прослойку между клиентом и классом к которому идет обращение.
 * Заместитель имеет такой же интерфейс как и настоящий класс.
 * Заместитель может делать что-то до и после обращения к классу, а может выполнять работу сам (например использовать кэш).
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Класс - реальный
// ==================================================================

interface SomeInterface
{
    public function firstMethod();
    public function secondMethod();
    public function thirdMethod();
}

class RealClass implements SomeInterface
{
    public function firstMethod(){
        echo 'REAL CLASS DO FIRST THING !!!!!<hr/>';
    }
    public function secondMethod(){
        echo 'REAL CLASS DO SECOND THING !!!!!<hr/>';
    }
    public function thirdMethod(){
        echo 'REAL CLASS DO THIRD THING !!!!!<hr/>';
    }
}

// ==================================================================
// ======= Класс - заместитель
// ==================================================================

class ProxyClass implements SomeInterface
{
    protected $real = null;

    public function firstMethod(){
        if(rand(1,20) % 2 == 0){
            $this->getRealClass()->firstMethod();
        } else {
            echo 'PROXY CLASS DO FIRST THING !!!!!<hr/>';
        }
    }

    public function secondMethod(){
        if(rand(1,20) % 2 == 0){
            $this->getRealClass()->secondMethod();
        } else {
            echo 'PROXY CLASS DO SECOND THING !!!!!<hr/>';
        }
    }

    public function thirdMethod(){
        if(rand(1,20) % 2 == 0){
            $this->getRealClass()->thirdMethod();
        } else {
            echo 'PROXY CLASS DO THIRD THING !!!!!<hr/>';
        }
    }

    protected function getRealClass()
    {
        if(!$this->real){
            $this->real = new RealClass();
            echo 'CREATING REAL CLASS<hr/>';
        } else {
            echo 'REAL CLASS ALREADY EXISTS<hr/>';
        }
        return $this->real;
    }
}

// ==================================================================
// Тесты
// ==================================================================

$proxy = new ProxyClass();
$proxy->firstMethod();
$proxy->thirdMethod();
$proxy->secondMethod();
$proxy->firstMethod();
$proxy->thirdMethod();
$proxy->firstMethod();
$proxy->firstMethod();
