<?php
namespace Tests\Utils;

use Maatwebsite\LaravelExcel\Contract\SerialiserInterface;

class FirstColumnOnlySerialiser implements SerialiserInterface
{
    public function getData($data)
    {
        $arrayValues = $data->toArray();
        return [$arrayValues['field1']];
    }

    public function getHeaderRow()
    {
        return ['HEADER'];
    }
}
