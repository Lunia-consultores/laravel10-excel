<?php
namespace Tests\Unit;

use Maatwebsite\LaravelExcel\Exporter\AbstractSpreadsheet;
use Maatwebsite\LaravelExcel\Factory\ExporterFactory;
use Maatwebsite\LaravelExcel\Factory\ImporterFactory;
use TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider()
    {
        //Test services
        $this->assertTrue($this->app->bound('laravel-excel/exporter'));
        $this->assertTrue($this->app->bound('laravel-excel/importer'));
        $this->assertInstanceOf(
            ExporterFactory::class,
            $this->app->make('laravel-excel/exporter')
        );
        $this->assertInstanceOf(
            ImporterFactory::class,
            $this->app->make('laravel-excel/importer')
        );
        //Test aliases
        $this->assertInstanceOf(
            AbstractSpreadsheet::class,
            Exporter::make("Excel")
        );
        $this->assertInstanceOf(
            AbstractSpreadsheet::class,
            Importer::make("Excel")
        );
    }
}
