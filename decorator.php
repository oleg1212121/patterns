<?php

interface WriterInterface
{
    public function showLabor();
}

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

class Decorator implements WriterInterface
{
    protected $writer;

    public function __construct($writer)
    {
        $this->writer = $writer;
    }

    public function showLabor()
    {
        $author = get_class($this->writer);
        echo 'Published by our Agency</br>';
        echo $this->writer->showLabor() . '</br>';
        echo "Author is {$author}</br>";
    }
}


$author = new Pushkin('Буря мглою небо кроет вихри снежные крутя то как зверь она завоет то заплачет как дитя');
$agency = new Decorator($author);

$agency->showLabor();