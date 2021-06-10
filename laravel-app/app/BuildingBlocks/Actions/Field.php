<?php

namespace App\BuildingBlocks\Actions;

interface Field
{
    public function all(): array;

    public function alias(): string;

    public function default(): mixed;

    public function name(): string;

    public function options(): array;

    public function required(): bool;

    public function types(): array;

    public function hidden(): bool;

    public function validationRules(): array;

    public function openApiParameter(): array;
}
