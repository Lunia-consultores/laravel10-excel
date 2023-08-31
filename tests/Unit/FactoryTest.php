<?php
namespace Tests\Unit;


use Maatwebsite\LaravelExcel\Exporter\Excel;
use Maatwebsite\LaravelExcel\Factory\ExporterFactory;
use Maatwebsite\LaravelExcel\Factory\ImporterFactory;
use Maatwebsite\LaravelExcel\Importer\Csv;
use Maatwebsite\LaravelExcel\Importer\OpenOffice;
use TestCase;

class FactoryTest extends TestCase
{
    public function test_factory_can_create_csv()
    {
        $factory = new ImporterFactory();
        $spreadsheet = $factory->make('Csv');
        $this->assertInstanceOf(
            Csv::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::CSV,
            $spreadsheet->getType()
        );
    }

    public function test_factory_can_create_odt()
    {
        $factory = new ImporterFactory();
        $spreadsheet = $factory->make('OpenOffice');
        $this->assertInstanceOf(
            OpenOffice::class,
            $factory->make('OpenOffice')
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::ODS,
            $spreadsheet->getType()
        );
    }

    public function test_factory_can_create_xls()
    {
        $factory = new ImporterFactory();
        $spreadsheet = $factory->make('Excel');
        $this->assertInstanceOf(
            Excel::class,
            $factory->make('Excel')
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::XLSX,
            $spreadsheet->getType()
        );
    }
    public function test_exporter_factory_can_create_csv()
    {
        $factory = new ExporterFactory();
        $spreadsheet = $factory->make('Csv');
        $this->assertInstanceOf(
            \Maatwebsite\LaravelExcel\Exporter\Csv::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::CSV,
            $spreadsheet->getType()
        );
    }

    public function test_exporter_factory_can_create_odt()
    {
        $factory = new ExporterFactory();
        $spreadsheet = $factory->make('OpenOffice');
        $this->assertInstanceOf(
            \Maatwebsite\LaravelExcel\Exporter\OpenOffice::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::ODS,
            $spreadsheet->getType()
        );
    }

    public function test_exporter_factory_can_create_xls()
    {
        $factory = new ExporterFactory();
        $spreadsheet = $factory->make('Excel');
        $this->assertInstanceOf(
            \Maatwebsite\LaravelExcel\Exporter\Excel::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::XLSX,
            $spreadsheet->getType()
        );
    }
}
