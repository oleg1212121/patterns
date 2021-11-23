<?php

interface DataInterface
{
    public function prepareData(array $data);
}

abstract class Data implements DataInterface
{
    protected $data = null;

    public function getData()
    {
        return $this->data;
    }

    abstract function prepareData(array $data);
}

class ExcelData extends Data
{
    public function prepareData(array $data)
    {
        $content = '';

        foreach ($data as $k => $item) {
            $content .= "<$k>$item</$k>";
        }

        $this->data = '<?xml version="1.1" encoding="UTF-8" ?><root>'.$content.'</root>';
    }
}


class JSONData extends Data
{
    public function prepareData(array $data)
    {
        $this->data = json_encode($data);
    }
}

class ProvideData
{
    protected $data;

    public function __construct(DataInterface $data)
    {
        $this->data = $data;
    }

    public function prepare(array $data)
    {
        $this->data->prepareData($data);
    }

    public function sendEmail()
    {
        echo "Sending email with : {$this->data->getData()}";
        echo '<hr/>';
    }


    public function sendMessage()
    {
        echo "Sending MESSAGE with : {$this->data->getData()}";
        echo '<hr/>';
    }
}

$obj_1 = new ExcelData();
$obj_2 = new JSONData();

$data = [
    'a' => 234,
    'b' => 'zak',
    'c' => '+----_=+++-__+=='
];

$provider = new ProvideData($obj_1);
$provider_2 = new ProvideData($obj_2);

$provider->prepare($data);
$provider_2->prepare($data);

$provider->sendEmail();
$provider_2->sendEmail();

$provider->sendMessage();
$provider_2->sendMessage();
