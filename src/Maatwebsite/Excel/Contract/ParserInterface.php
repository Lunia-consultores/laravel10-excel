<?php
namespace Maatwebsite\LaravelExcel\Contract;

interface ParserInterface
{
    public function transform($array, $header);
}
