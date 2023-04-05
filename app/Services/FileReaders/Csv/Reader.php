<?php

namespace App\Services\FileReaders\Csv;

use App\Services\FileReaders\Contracts\ReaderContract;
use ArrayAccess;

class Reader implements ReaderContract, \Iterator, \Countable, ArrayAccess
{
    private string $filepath;

    private array $lines = [];

    private $position = 1;

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
    }

    public function read(): void
    {
        if (!file_exists($this->filepath) || !is_readable($this->filepath)) {
            throw new \InvalidArgumentException('Bad filepath provided.');
        }

        $resource = fopen($this->filepath, 'rb');

        while (($line = fgetcsv($resource)) !== false) {
            $this->lines[] = $line;
        }
    }

    public function headers(): array
    {
        return $this->lines[0];
    }

    public function count(): int
    {
        return count($this->lines);
    }

    public function current(): mixed
    {
        $i = $this->position;

        return $this->lines[$i];
    }
    
    public function key(): mixed
    {
        return $this->position;
    }
    
    public function next(): void
    {
        ++$this->position;
    }
    
    public function rewind(): void
    {
        $this->position = 1;
    }

    public function valid(): bool
    {
        $i = $this->position;

        return isset($this->lines[$i]);
    }

    public function offsetSet($offset, $value) : void
    {
        if (is_null($offset)) {
            $this->lines[] = $value;
        } else {
            $this->lines[$offset] = $value;
        }
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->lines[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->lines[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return isset($this->lines[$offset]) ? $this->lines[$offset] : null;
    }
}