<?php
namespace Maatwebsite\LaravelExcel;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\LaravelExcel\Factory\ExporterFactory;
use Maatwebsite\LaravelExcel\Factory\ImporterFactory;

class ExcelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Exporter', ExporterFacade::class);
        $loader->alias('Importer', ImporterFacade::class);
    }

    public function register(): void
    {
        $this->app->singleton('laravel-excel/exporter', function () {
            return new ExporterFactory();
        });
        $this->app->singleton('laravel-excel/importer', function () {
            return new ImporterFactory();
        });
    }

}
