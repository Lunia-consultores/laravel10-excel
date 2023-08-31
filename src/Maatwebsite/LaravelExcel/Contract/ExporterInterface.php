<?php
namespace Maatwebsite\LaravelExcel\Contract;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface ExporterInterface
{
    public function load(Collection $data);
    public function loadQuery(Builder $query);
    public function setChunk($size);
    public function setSerialiser(SerialiserInterface $serialiser);
    public function save($filename);
    public function stream($filename);
}
