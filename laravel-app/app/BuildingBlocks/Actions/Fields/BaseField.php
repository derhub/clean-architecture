<?php

namespace App\BuildingBlocks\Actions\Fields;

use App\BuildingBlocks\Actions\Field;
use ArrayAccess;

class BaseField implements ArrayAccess, Field
{
    protected array $openApiParameter = [];

    /**
     * @var array<string, callable>
     */
    protected array $modifiers = [];

    public function __construct(private array $config)
    {
        $this->addPayloadModifier(
            static function ($payload) {
                if (\is_string($payload)) {
                    $payload = \trim($payload);
                    $payload = $payload === '' ? null : $payload;
                }

                return $payload;
            }
        );
    }

    public function all(): array
    {
        return $this->config;
    }

    public function setAlias(string $alias): self
    {
        $this->config['alias'] = $alias;

        return $this;
    }

    public function alias(): string
    {
        return $this->config['alias'] ?? '';
    }

    public function setDefault(mixed $default): self
    {
        $this->config['default'] = $default;

        return $this;
    }

    public function default(): mixed
    {
        return $this->config['default'] ?? null;
    }

    public function name(): string
    {
        return $this->config['name'] ?? '';
    }

    public function setOptions(array $options): self
    {
        $this->config['options'] = $options;

        return $this;
    }

    public function options(): array
    {
        return $this->config['options'] ?? [];
    }

    public function setRequired(bool $isRequired): self
    {
        $this->config['required'] = $isRequired;

        return $this;
    }

    public function required(): bool
    {
        return $this->config['required'] ?? false;
    }

    public function setTypes(array $types): self
    {
        $this->config['types'] = $types;

        return $this;
    }

    public function types(): array
    {
        return $this->config['types'] ?? ['string'];
    }

    public function hide(bool $isHidden = true): self
    {
        $this->config['hidden'] = $isHidden;

        return $this;
    }

    public function hidden(): bool
    {
        return $this->config['hidden'] ?? false;
    }

    public function setOpenApiParameter(
        array $parameter
    ): self {
        $this->openApiParameter = $parameter;

        return $this;
    }

    public function openApiParameter(): array
    {
        return $this->openApiParameter;
    }

    public function setValidationRules(array $rules): self
    {
        $this->config['rules'] = $rules;

        return $this;
    }

    public function validationRules(): array
    {
        return $this->config['rules'] ?? [];
    }

    public function offsetExists($offset): bool
    {
        return isset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->config[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->config[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->config[$offset]);
    }

    public function addPayloadModifier(callable $callback): self
    {
        $this->modifiers[] = $callback;

        return $this;
    }

    public function applyPayloadModifications(mixed $payload): mixed
    {
        if (empty($this->modifiers)) {
            return $payload;
        }

        foreach ($this->modifiers as $modifier) {
            $payload = $modifier($payload);
        }

        return $payload;
    }

    public function nullable(): bool
    {
        return \in_array('null', $this->types());
    }
}
