<?php

namespace App;

use File;

use function array_keys;
use function array_values;
use function str_replace;

class StubPrinter
{
    private array $data;

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function byPath(string $stubPath, array $data): self
    {
        $stubContent = File::get($stubPath);
        $self = new self($stubContent);
        $self->data = $data;

        return $self;
    }

    public function __construct(private string $stubContent)
    {
    }


    public function getContent(): string
    {
        return str_replace(
            array_keys($this->data),
            array_values($this->data),
            $this->stubContent
        );
    }

    public function getData(): array
    {
        return $this->data;
    }
}
