<?php
namespace Maatwebsite\LaravelExcel\Exporter;

use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\CSV\Writer;

class Csv extends AbstractSpreadsheet
{
    public function getType(): string
    {
        return Type::CSV;
    }

    public function createWriter(): Writer
    {
        return WriterEntityFactory::createCSVWriter();
    }
}
