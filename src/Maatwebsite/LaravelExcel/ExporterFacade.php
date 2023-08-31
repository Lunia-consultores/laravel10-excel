<?php

namespace Maatwebsite\LaravelExcel;

use Illuminate\Support\Facades\Facade;

class ExporterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-excel/exporter';
    }
}
