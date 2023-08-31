<?php
namespace Maatwebsite\LaravelExcel\Factory;

use ReflectionClass;

class ImporterFactory
{
    /**
     * @throws \ReflectionException
     */
    public function make($type)
    {
        $class = new ReflectionClass('Maatwebsite\\LaravelExcel\\Importer\\'.$type);
        return $class->newInstanceArgs();
    }
}
