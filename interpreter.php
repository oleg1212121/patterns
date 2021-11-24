<?php
/**
 *           ИНТЕРПРЕТАТОР
 * ---------------------------------
 * Поведенческий шаблон проектирования
 *
 * Применяется для решения типичной, но часто изменяющейся задачи (например Парсинг).
 * Обычно содержит два вида классов - "НетерминальноеВыражение" и "ТерминальноеВыражение" (Рекурсивное).
 * Нетерминальное выражение должно вернуть конечное значение.
 * Терминальное выражение должно быть разобрано рекурсивно на терминальное и нетерминальное.
 * В итоге получится конечное значение всей задачи.
 *
 * Главный недостаток - высокая сложность реализации при большом количестве правил интерпретации.
 * Так же большая вероятность медленной работы интерпретатора.
 *
 * Примеры - язык SQL, математические выражения в строке и т.п.
 */

// ==================================================================
// Структура
// ==================================================================

abstract class AbstractExpression
{
    abstract public function interprete();
}

// ==================================================================
// ======= Классы возвращающие конечное значение (нетерминальные)
// ==================================================================

class Number extends AbstractExpression
{
    protected $number;
    public function __construct($number)
    {
        $this->number = $number;
    }

    public function interprete()
    {
        return intval($this->number);
    }
}


class Add extends AbstractExpression
{
    protected $left;
    protected $right;
    public function __construct($left, $right)
    {
        $this->left = new Number($left);
        $this->right = new Number($right);
    }

    public function interprete()
    {
        return $this->left->interprete() + $this->right->interprete();
    }
}

class Subtract extends AbstractExpression
{
    protected $left;
    protected $right;
    public function __construct($left, $right)
    {
        $this->left = new Number($left);
        $this->right = new Number($right);
    }

    public function interprete()
    {
        return $this->left->interprete() - $this->right->interprete();
    }
}

class Multiply extends AbstractExpression
{
    protected $left;
    protected $right;
    public function __construct($left, $right)
    {
        $this->left = new Number($left);
        $this->right = new Number($right);
    }

    public function interprete()
    {
        return $this->left->interprete() * $this->right->interprete();
    }
}

class Divide extends AbstractExpression
{
    protected $left;
    protected $right;
    public function __construct($left, $right)
    {
        $this->left = new Number($left);
        $this->right = new Number($right);
    }

    public function interprete()
    {
        return $this->left->interprete() / $this->right->interprete();
    }
}

// ==================================================================
// ======= Классы терминальных выражений (с рекурсией)
// ==================================================================

class BracketsExpression extends AbstractExpression
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function interprete()
    {
        preg_match("/\([0-9\-\+\/\*]{0,}\)/", $this->string, $matches);
        if(count($matches) == 0){
            return $this->string;
        } else {
            $indoor = (new SimpleExpression(str_replace(['(', ')'], '',$matches[0])))->interprete();
            $this->string = str_replace( $matches[0], $indoor, $this->string);
            $new = (new BracketsExpression($this->string))->interprete();
            return $new;
        }
    }
}

class DivideExpression extends AbstractExpression
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function interprete()
    {
        echo $this->string.'<hr/>';
        preg_match("/[^\-\+\*\/]+\/[^\-\+\*\/]+/", $this->string, $matches);
        if(count($matches) == 0){
            return $this->string;
        } else {
            $parts = explode('/', $matches[0]);
            $indoor = (new Divide(...$parts))->interprete();
            $this->string = str_replace( $matches[0], $indoor, $this->string);
            $new = (new DivideExpression($this->string))->interprete();
            return $new;
        }
    }
}

class MultiplyExpression extends AbstractExpression
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function interprete()
    {
        echo $this->string.'<hr/>';
        preg_match("/[^\-\+\*\/]+\*[^\-\+\*\/]+/", $this->string, $matches);
        if(count($matches) == 0){
            return $this->string;
        } else {
            $parts = explode('*', $matches[0]);
            $indoor = (new Multiply(...$parts))->interprete();
            $this->string = str_replace( $matches[0], $indoor, $this->string);
            $new = (new MultiplyExpression($this->string))->interprete();
            return $new;
        }
    }
}


class SimpleExpression extends AbstractExpression
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function interprete()
    {
        echo $this->string.'<hr/>';
        $withoutDivideExpression = (new DivideExpression($this->string))->interprete();
        $this->string = (new MultiplyExpression($withoutDivideExpression))->interprete();
        $res = 0;
        $cur = '';
        $str = str_split($this->string);
        for($i = strlen($this->string) - 1; $i >=0; $i--){
            if($str[$i] == '+'){
                $res += intval($cur);
                $cur = '';
            } else if ($str[$i] == '-') {
                $res -= intval($cur);
                $cur = '';
            } else {
                $cur = $str[$i] . $cur;
            }
        }
        return $res + intval($cur);
    }
}

// ==================================================================
// Тесты
// ==================================================================

class Parser extends AbstractExpression
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function interprete()
    {
        echo $this->string.'<hr/>';
        $withoutBracketsExpression = (new BracketsExpression($this->string))->interprete();
        $simpleExpression = (new SimpleExpression($withoutBracketsExpression))->interprete();
        return $simpleExpression;
    }
}
$str = "1+440/220+33-44*2-(-10+20-2+2+7/7-(33-33+2)-(33-44+12))";
$parser = new Parser($str);
echo $parser->interprete();