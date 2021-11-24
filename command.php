<?php
/**
 *             КОМАНДА
 * ---------------------------------
 * Поведенческий шаблон проектирования
 *
 * Простые запросы/операции заворачиваются в отдельные объекты.
 * Данные объекты можно поместить в очередь и выполнить последовательно.
 * Таким образом можно получить историю выполнения команд.
 * Параллельно выполнению каждой команды из очереди, можно выполнять дополнительные манипуляции (логирование и т.д).
 * Так же должна быть реализована возможность отменять/повторять команды.
 *
 * Примеры использования - транзакции, макросы, кнопки интерфейса и др.
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Классы комманд
// ==================================================================
interface CommandInterface
{
    public function execute($value);
    public function undo($value);
}

abstract class Command implements CommandInterface
{
    protected $value;
    public function __construct($value)
    {
        $this->value = $value;
    }
}

class AddCommand extends Command
{
    public function execute($value)
    {
        return $this->value + $value;
    }

    public function undo($value)
    {
        return $value - $this->value;
    }
}


class SubtractCommand extends Command
{
    public function execute($value)
    {
        return $value - $this->value;
    }

    public function undo($value)
    {
        return $value + $this->value;
    }
}

class MultiplyCommand extends Command
{
    public function execute($value)
    {
        return $value * $this->value;
    }

    public function undo($value)
    {
        return $value / $this->value;
    }
}

class DivideCommand extends Command
{
    public function execute($value)
    {
        return $value / $this->value;
    }

    public function undo($value)
    {
        return $value * $this->value;
    }
}

// ==================================================================
// ======= Класс калькулятора. Выполняет и логгирует команды.
// ==================================================================

class Calculator
{
    protected $commands = [];
    protected $current = 0;
    protected $commandsCounter = 0;

    public function execute(Command $command)
    {
        $this->current = $command->execute($this->current);
        $this->commands []= $command;
        $this->commandsCounter++;
        echo "Current value is {$this->current}<hr/>";
    }

    public function undo($steps)
    {
        while($steps && $this->commandsCounter){
            $this->current = $this->commands[$this->commandsCounter - 1]->undo($this->current);
            unset($this->commands[$this->commandsCounter - 1]);
            $this->commandsCounter--;
            $steps--;
            echo "Current value is {$this->current}<hr/>";
        }
    }

    public function redo($steps)
    {
        $i = 0;
        while($steps > $i){
            $this->execute($this->commands[$i]);
            $i++;
        }
    }
}

// ==================================================================
// Тесты
// ==================================================================

$calculator = new Calculator();
$calculator->execute(new AddCommand(5));
$calculator->execute(new AddCommand(10));
$calculator->execute(new AddCommand(15));
echo '<hr/>';
$calculator->redo(10);
$calculator->undo(20);