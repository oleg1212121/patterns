<?php
/**
 *            ДЕКОРАТОР
 * ---------------------------------
 * Структурный шаблон проектирования
 *
 * Позволяет оборачивать объекты в полезные обёртки.
 * Обёртки могут добавлять некоторую логику, но интерфейс объекта не изменяется.
 * Паттерн основан на агрегации вместо наследования. Меньше проблем с наследованием и проще масштабирование.
 */

// ==================================================================
// Структура
// ==================================================================

interface WriterInterface
{
    public function showLabor();
}

// ==================================================================
// ======= Класс Писателя
// ==================================================================

class Author implements WriterInterface
{
    protected $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function showLabor()
    {
        return $this->text;
    }
}

class Pushkin extends Author
{

}

// ==================================================================
// ======= Класс издательства (декоратор)
// ==================================================================

class PublisherDecorator implements WriterInterface
{
    protected $writer;

    public function __construct($writer)
    {
        $this->writer = $writer;
    }

    public function showLabor()
    {
        $author = get_class($this->writer);
        echo "Published by our Agency</br> {$this->writer->showLabor()} </br> Author is {$author}</br>";
    }
}

// ==================================================================
// Тесты
// ==================================================================

$author = new Pushkin('Буря мглою небо кроет вихри снежные крутя то как зверь она завоет то заплачет как дитя');
$agency = new PublisherDecorator($author);
$agency->showLabor();