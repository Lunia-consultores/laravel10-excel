<?php
namespace Maatwebsite\LaravelExcel\Parser;

use Maatwebsite\LaravelExcel\Contract\ParserInterface;
use RuntimeException;

class BasicParser implements ParserInterface
{
    public function transform($array, $header): array
    {
        if ($header) {
            $array = array_combine($header, $array);

            if (!$array) {
                throw new RuntimeException('Unvalid header');
            }
        }

        return $array;
    }
}
