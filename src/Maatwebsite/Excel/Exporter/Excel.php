<?php
namespace Maatwebsite\LaravelExcel\Exporter;

use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\XLSX\Writer;

class Excel extends AbstractSpreadsheet
{
    public function getType(): string
    {
        return Type::XLSX;
    }

    public function createWriter(): Writer
    {
        return WriterEntityFactory::createXLSXWriter();
    }
}
