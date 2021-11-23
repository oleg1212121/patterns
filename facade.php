<?php

class Car
{
    public function getSupplies()
    {
        echo 'Car moving to the store for taking supplies<hr/>';
        echo 'Car moving back to the market<hr/>';
    }
}

class Seller
{
    public function openMarket()
    {
        echo "Seller open market and do job<hr/>";
    }
}

class Manager
{
    public function manage()
    {
        echo "Manager is organising paper-work<hr/>";
    }
}

class Security
{
    public function watch()
    {
        echo 'Guards are protecting market<hr/>';
    }
}


class MarketFacade
{
    public $car;
    public $seller;
    public $manager;
    public $guard;

    public function __construct()
    {
        $this->car = new Car();
        $this->seller = new Seller();
        $this->manager = new Manager();
        $this->guard = new Security();
    }

    public function startWorking()
    {
        $this->car->getSupplies();
        $this->seller->openMarket();
        $this->guard->watch();
        $this->manager->manage();

        echo "END OF WORK AT THE EVENING";
    }
}

$market = new MarketFacade();
$market->startWorking();