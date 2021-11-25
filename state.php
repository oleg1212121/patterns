<?php
/**
 *            СОСТОЯНИЕ
 * ---------------------------------
 * Поведенческий шаблон проектирования
 *
 * Позволяет объекту менять свое поведение в зависимости от своего состояния.
 * Создается впечатление, что изменяется сам объект, но на самом деле меняется только состояние.
 * Должна быть определена логика смены состояний.
 * Каждое состояние имеет свою логику работы объекта.
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Классы состояний (принимают контекст)
// ==================================================================

abstract class AbstractState
{
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function handle(){
        $class = get_class($this);
        echo "This is handle from {$class} class <hr/>";
    }
}

class FirstState extends AbstractState
{
    public function handle()
    {
        parent::handle();
        $this->context->setState('B');
    }
}

class SecondState extends AbstractState
{
    public function handle()
    {
        parent::handle();
        $this->context->setState('C');
    }
}

class ThirdState extends AbstractState
{
    public function handle()
    {
        parent::handle();
        $this->context->setState('A');
    }
}

// ==================================================================
// ======= Класс контекста (имеет конкретное состояние и может его менять)
// ==================================================================

class Context
{
    protected $state;

    public function __construct()
    {
        $this->setState('A');
    }

    public function execute()
    {
        $this->state->handle();
    }

    public function setState($state)
    {
        if ($state == 'A') {
            $this->state = new FirstState($this);
        } elseif ($state == 'B') {
            $this->state = new SecondState($this);
        } elseif ($state == 'C') {
            $this->state = new ThirdState($this);
        }
    }
}

// ==================================================================
// Тесты
// ==================================================================

$context = new Context();
$context->execute();
$context->execute();
$context->execute();
$context->execute();
$context->execute();
$context->execute();
$context->execute();
$context->execute();
$context->execute();
$context->execute();