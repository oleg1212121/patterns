<?php
/**
 *               МОСТ
 * ---------------------------------
 * Структурный шаблон проектирования
 *
 * Используется для разделения бизнес-логики/большого класса на независимые - абстракцию и реализацию.
 * Абстракция будет принимать объект реализации и в дальнейшем делегировать ему некоторую логику.
 * И абстракции и реализации должны следовать своим интерфейсам, чтобы исключить ошибки.
 *
 */

// ==================================================================
// Структура
// ==================================================================

// ==================================================================
// ======= Различные классы преобразователей данных (Реализации/имплементации)
// ==================================================================

interface DataPreparerInterface
{
    public function prepareData(array $data);
}

abstract class DataPreparer implements DataPreparerInterface
{
    protected $data = null;

    public function getData()
    {
        return $this->data;
    }

    abstract function prepareData(array $data);
}

class PreparerExcelData extends DataPreparer
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


class PreparerJSONData extends DataPreparer
{
    public function prepareData(array $data)
    {
        $this->data = json_encode($data);
    }
}

// ==================================================================
// ======= Различные классы поставщика данных (Абстракции)
// ==================================================================

interface ProviderInterface
{
    public function send();
}

abstract class Provider implements ProviderInterface
{
    protected $data;

    public function __construct(DataPreparerInterface $data)
    {
        $this->data = $data;
    }

    public function prepare(array $data)
    {
        $this->data->prepareData($data);
    }

    abstract public function send();
}

class SendEmail extends Provider
{
    public function send()
    {
        echo "Sending email with : {$this->data->getData()}";
        echo '<hr/>';
    }
}

class SendMessage extends Provider
{
    public function send()
    {
        echo "Sending MESSAGE with : {$this->data->getData()}";
        echo '<hr/>';
    }
}

$obj_1 = new PreparerExcelData();
$obj_2 = new PreparerJSONData();

$data = [
    'a' => 234,
    'b' => 'zak',
    'c' => '+----_=+++-__+=='
];

$provider = new SendEmail($obj_1);
$provider_2 = new SendMessage($obj_2);

$provider->prepare($data);
$provider_2->prepare($data);

$provider->send();
$provider_2->send();
