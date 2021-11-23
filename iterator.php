<?php

interface IteratorInterface
{
    public function hasNext();
    public function next();
}

class MyIterator implements IteratorInterface
{
    protected $items;
    protected $pos = 0;
    protected $length = 0;
    public function __construct($items)
    {
        $this->length = count($items);
        $this->items = $items;
    }


    public function hasNext()
    {
        if($this->length > 0 && $this->pos < $this->length){
            return true;
        } else {
            return false;
        }
    }

    public function next()
    {
        $item = $this->items[$this->pos];
        $this->pos++;
        return $item->info();
    }

}

interface ItemIteratorInterface
{
    public function info();
}

class Item implements ItemIteratorInterface
{
    protected $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function info()
    {
        return $this->price;
    }
}


class OtherItem implements ItemIteratorInterface
{
    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function info()
    {
        return $this->amount;
    }
}


class AnotherItem implements ItemIteratorInterface
{
    protected $price;
    protected $discount;

    public function __construct($price, $discount)
    {
        $this->price = $price;
        $this->discount = $discount;
    }

    public function info()
    {
        return $this->price - (($this->price * $this->discount)/100);
    }
}

class Aggregator
{
    public $items;

    public function __construct()
    {
        $this->items = [
            new Item(400),
            new Item(600),
            new OtherItem(522),
            new AnotherItem(444, 10),
        ];
    }

    public function createIterator()
    {
        return new MyIterator($this->items);
    }
}

$iterator = (new Aggregator())->createIterator();

while($iterator->hasNext()){
   echo $iterator->next().'<hr/>';
}