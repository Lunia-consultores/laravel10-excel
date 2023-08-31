<?php
namespace Maatwebsite\LaravelExcel\Importer;

use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\XLSX\Reader;

class Excel extends AbstractSpreadsheet
{
    public function getType(): string
    {
        return Type::XLSX;
    }

    public function createReader(): Reader
    {
        return ReaderEntityFactory::createXLSXReader();
    }
}
