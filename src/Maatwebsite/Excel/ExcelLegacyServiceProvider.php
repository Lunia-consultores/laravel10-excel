<?php

namespace Maatwebsite\LaravelExcel;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\LaravelExcel\Factory\ExporterFactory;
use Maatwebsite\LaravelExcel\Factory\ImporterFactory;

class ExcelLegacyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Exporter', '\Maatwebsite\LaravelExcel\ExporterFacade');
        $loader->alias('Importer', '\Maatwebsite\LaravelExcel\ImporterFacade');
    }

    public function register(): void
    {
        $this->app->bind('laravel-excel/exporter', function () {
            return new ExporterFactory();
        });
        $this->app->bind('laravel-excel/importer', function () {
            return new ImporterFactory();
        });
    }
}
