<?php
namespace Maatwebsite\LaravelExcel\Importer;

use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\CSV\Reader;

class Csv extends AbstractSpreadsheet
{
    public function getType(): string
    {
        return Type::CSV;
    }

    public function createReader(): Reader
    {
        return ReaderEntityFactory::createCSVReader();
    }
}
