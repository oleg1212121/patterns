<?php

abstract class Product
{
    protected $price;
    protected $finalPrice;

    public function __construct($price)
    {
        $this->price = $price;
        $this->finalPrice = $price;
    }

    public function setFinalPrice($price)
    {
        $this->finalPrice = $price;
    }

    public function getFinalPrice()
    {
        return $this->finalPrice;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function accept(VisitorInterface $visitor)
    {
        $visitor->visit($this);
    }
}

class Juice extends Product
{

}
class Apple extends Product
{

}

interface VisitorInterface
{
    public function visit(Product $product);
}

class DiscounterVisitor implements VisitorInterface
{
    protected $discount;
    public $name;

    public function __construct($discount, $name)
    {
        $this->discount = $discount;
        $this->name = $name;
    }

    public function visit(Product $product)
    {
        $currentPrice = $product->getPrice();
        $newPrice = $currentPrice - ($currentPrice * $this->discount) / 100;
        $product->setFinalPrice($newPrice);
        $productClass = get_class($product);
        echo "It is a {$this->name} .There is a {$productClass} product with {$currentPrice} current price and {$newPrice} new price!<hr/>";
    }
}

$firm_1 = new DiscounterVisitor(20, 'MARKET');

$firm_2 = new DiscounterVisitor(30, 'WHOLESALE STORE');

$product_1 = new Juice(200);
$product_2 = new Apple(440);

$product_1->accept($firm_1);
$product_1->accept($firm_2);

$product_2->accept($firm_1);
$product_2->accept($firm_2);

