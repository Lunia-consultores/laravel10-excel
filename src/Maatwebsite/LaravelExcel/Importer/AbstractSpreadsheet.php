<?php

namespace Maatwebsite\LaravelExcel\Importer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\LaravelExcel\Contract\ImporterInterface;
use Maatwebsite\LaravelExcel\Contract\ParserInterface;
use Maatwebsite\LaravelExcel\Parser\BasicParser;

abstract class AbstractSpreadsheet implements ImporterInterface
{
    protected string $path;
    protected string $type;
    protected BasicParser $parser;
    protected int $sheet;
    protected Model|bool $model;
    protected int $hasHeaderRow;
    protected Collection $callbacks;

    public function __construct()
    {
        $this->path = '';
        $this->sheet = 1;
        $this->hasHeaderRow = 0;
        $this->type = $this->getType();
        $this->parser = new BasicParser();
        $this->model = false;
        $this->callbacks = collect([]);
    }

    public function __call($name, $args)
    {
        $this->callbacks->push([$name, $args]);
        return $this;
    }

    public function load($path): static
    {
        $this->path = $path;
        return $this;
    }

    public function setSheet($sheet): static
    {
        $this->sheet = $sheet;
        return $this;
    }

    public function hasHeader($hasHeaderRow): void
    {
        $this->hasHeaderRow = $hasHeaderRow;
    }

    public function setParser(ParserInterface $parser): static
    {
        $this->parser = $parser;
        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;
        return $this;
    }

    abstract public function getType();

    abstract public function createReader();

    public function getCollection(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        $headers = false;

        $reader = $this->open();
        $collection = collect([]);

        foreach ($reader->getSheetIterator() as $index => $sheet) {
            if ($index !== $this->sheet) {
                continue;
            }

            $collection = $this->model ? $this->model->newCollection() : collect([]);

            foreach ($sheet->getRowIterator() as $rowindex => $row) {
                if ($rowindex == 1 && $this->hasHeaderRow) {
                    $headers = $row->toArray();
                } else {
                    $data = $this->parser->transform($row->toArray(), $headers);

                    if ($data) {
                        if ($this->model) {
                            $data = $this->model->newInstance($data);
                        }

                        $collection->push($data);
                    }
                }
            }
        }

        $reader->close();

        return $collection;
    }

    public function save($updateIfEquals = []): void
    {
        if (!$this->model) {
            return;
        }

        $headers = false;

        $reader = $this->open();

        $updateIfEquals = array_flip($updateIfEquals);

        foreach ($reader->getSheetIterator() as $index => $sheet) {
            if ($index !== $this->sheet) {
                continue;
            }

            foreach ($sheet->getRowIterator() as $rowindex => $row) {
                if ($rowindex == 1 && $this->hasHeaderRow) {
                    $headers = $row->toArray();
                } else {
                    $data = $this->parser->transform($row->toArray(), $headers);
                    if ($data) {
                        $relationships = [];
                        $when = array_intersect_key($data, $updateIfEquals);
                        $values = array_diff_key($data, $when);

                        foreach ($values as $key => $val) {
                            if (method_exists($this->model, $key)) {
                                unset($values[$key]);
                                $relationships[$key] = $val;
                            }
                        }

                        $uniqueBy = array_keys($when);
                        if (!empty($uniqueBy)) {
                            $this->model->query()->upsert($values, $uniqueBy, array_keys($values));
                        }

                        if (count($relationships)) {
                            $model = $this->model->query()->where($values)
                                ->orderBy($this->model->getKeyName(), 'desc')
                                ->first();
                            foreach ($relationships as $key => $val) {
                                if (is_array($val)) {
                                    $model->{$key}()->createMany($val);
                                } else {
                                    $model->{$key}()->associate($val);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    protected function open()
    {
        $reader = $this->createReader();
        $this->callbacks->each(function ($elem) use (&$reader) {
            call_user_func_array(array($reader, $elem[0]), $elem[1]);
        });
        $reader->open($this->path);

        return $reader;
    }
}
