<?php

namespace Maatwebsite\LaravelExcel\Factory;

use ReflectionClass;

class ExporterFactory
{
    /**
     * @throws \ReflectionException
     */
    public function make($type)
    {
        $class = new ReflectionClass('Maatwebsite\\LaravelExcel\\Exporter\\' . $type);
        return $class->newInstanceArgs();
    }
}
