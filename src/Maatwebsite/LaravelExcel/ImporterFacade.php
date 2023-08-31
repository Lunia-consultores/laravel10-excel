<?php
namespace Maatwebsite\LaravelExcel;

use Illuminate\Support\Facades\Facade;

class ImporterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-excel/importer';
    }

}
