<?php
namespace Maatwebsite\LaravelExcel\Importer;

use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ODS\Reader;

class OpenOffice extends AbstractSpreadsheet
{
    public function getType(): string
    {
        return Type::ODS;
    }

    public function createReader(): Reader
    {
        return ReaderEntityFactory::createODSReader();
    }
}
