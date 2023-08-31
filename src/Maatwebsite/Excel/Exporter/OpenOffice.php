<?php
namespace Maatwebsite\LaravelExcel\Exporter;

use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\ODS\Writer;

class OpenOffice extends AbstractSpreadsheet
{
    public function getType(): string
    {
        return Type::ODS;
    }

    public function createWriter(): Writer
    {
        return WriterEntityFactory::createODSWriter();
    }
}
