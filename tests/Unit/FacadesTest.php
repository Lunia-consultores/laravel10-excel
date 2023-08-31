<?php
namespace Tests\Unit;

use Maatwebsite\LaravelExcel\Factory\ExporterFactory;
use TestCase;

class FacadesTest extends TestCase
{
    public function test_facades_are_available()
    {
        $this->assertInstanceOf(
            ExporterFactory::class,
            Exporter::getFacadeRoot()
        );
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Factory\ImporterFactory::class,
            Importer::getFacadeRoot()
        );
    }
}
