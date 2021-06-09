<?php

namespace App\BuildingBlocks\ActionGenerator;

use File;

use function array_keys;
use function array_values;
use function str_replace;

class StubActionClassWriter
{
    public const FILE_EXIST = 0;
    public const WRITE_SUCCESS = 1;

    private array $data;

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function byPath(string $stubPath, array $data): self
    {
        return self::byContent(File::get($stubPath), $data);
    }

    public static function byContent(string $stubContent, array $data): self
    {
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

    public function write($overwrite = false): int
    {
        [
            '__class__' => $class,
            '__namespace__' => $namespace,
        ] = $this->getData();

        $directory =
            str_replace('\\', '/', $namespace);

        $file = $directory.'/'.$class.'.php';

        if (! $overwrite && File::exists($file)) {
            return self::FILE_EXIST;
        }

        File::ensureDirectoryExists($directory);
        File::put($file, $this->getContent());

        return self::WRITE_SUCCESS;
    }
}
