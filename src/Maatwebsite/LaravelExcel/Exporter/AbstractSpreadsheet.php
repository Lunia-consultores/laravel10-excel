<?php
namespace Maatwebsite\LaravelExcel\Exporter;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\LaravelExcel\Contract\ExporterInterface;
use Maatwebsite\LaravelExcel\Contract\SerialiserInterface;
use Maatwebsite\LaravelExcel\Serialiser\BasicSerialiser;

abstract class AbstractSpreadsheet implements ExporterInterface
{
    protected mixed $data;
    protected string $type;
    protected $serialiser;
    protected int $chuncksize;
    protected Collection $callbacks;

    public function __construct()
    {
        $this->data = [];
        $this->type = $this->getType();
        $this->serialiser = new BasicSerialiser();
        $this->callbacks = collect([]);
    }

    public function __call($name, $args)
    {
        $this->callbacks->push([$name, $args]);
        return $this;
    }

    public function load(Collection $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function loadQuery(Builder $query): static
    {
        $this->data = $query;
        return $this;
    }

    public function setChunk($size): static
    {
        $this->chunksize = $size;
        return $this;
    }

    public function setSerialiser(SerialiserInterface $serialiser): static
    {
        $this->serialiser = $serialiser;
        return $this;
    }

    abstract public function getType();

    abstract public function createWriter();

    public function save($filename): void
    {
        $writer = $this->create();
        $writer->openToFile($filename);
        $writer = $this->makeRows($writer);
        $writer->close();
    }

    public function stream($filename): void
    {
        $writer = $this->create();
        $writer->openToBrowser($filename);
        $writer = $this->makeRows($writer);
        $writer->close();
    }

    protected function create()
    {
        $writer = $this->createWriter();
        $this->callbacks->each(function ($elem) use (&$writer) {
            call_user_func_array(array($writer, $elem[0]), $elem[1]);
        });
        return $writer;
    }

    protected function makeRows($writer)
    {
        $headerRow = $this->serialiser->getHeaderRow();
        if (!empty($headerRow)) {
            $row = WriterEntityFactory::createRowFromArray($headerRow);
            $writer->addRow($row);
        }
        if ($this->data instanceof Builder) {
            if (isset($this->chunksize)) {
                $this->data->chunk($this->chunksize, function ($records) use ($writer) {
                    $this->addRowsDataToWriter($records, $writer);
                });
            } else {
                $this->addRowsDataToWriter($this->data->get(), $writer);
            }
        } else {
            $this->addRowsDataToWriter($this->data, $writer);
        }
        return $writer;
    }

    public function addRowsDataToWriter($data, $writer): void
    {
        foreach ($data as $record) {
            $recordData = $this->serialiser->getData($record);
            $row = WriterEntityFactory::createRowFromArray($recordData);
            $writer->addRow($row);
        }
    }
}
