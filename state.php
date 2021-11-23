<?php


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