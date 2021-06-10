<?php

namespace App\BuildingBlocks\Actions;

use App\BuildingBlocks\Actions\Fields\BaseField;

use Countable;
use Generator;
use IteratorAggregate;

class FieldManager implements IteratorAggregate, Countable, \ArrayAccess
{
    /**
     * FieldManager constructor.
     * @param BaseField[] $items
     */
    public function __construct(private array $items)
    {
    }

    public function all(): array
    {
        return \iterator_to_array($this->iterator());
    }

    public function iterator(string $keyBy = null): Generator
    {
        foreach ($this->items as $key => $field) {
            if (! $keyBy) {
                yield $key => $this->get($key);
            } else {
                yield $field[$keyBy] => $this->get($key);
            }
        }
    }

    public function replace(string $fieldName, string $fieldClass): BaseField
    {
        if (isset($this->items[$fieldName])) {
            throw FieldException::fieldNotFound(
                $fieldName,
                \array_keys($this->items)
            );
        }

        $field = $this->items[$fieldName];
        $newField = \call_user_func($fieldClass.'::fromReplace', $field);
        $this->items[$fieldName] = $newField;
        return $this->items[$fieldName];
    }

    public function get(string $fieldName): BaseField
    {
        if (! isset($this->items[$fieldName])) {
            throw FieldException::fieldNotFound(
                $fieldName,
                \array_keys($this->items)
            );
        }

        return $this->items[$fieldName];
    }

    public function getIterator(): iterable
    {
        return $this->iterator();
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
