<?php

namespace App\BuildingBlocks\ActionGenerator;

/**
 * Class TypesValidationRulesGenerator
 * @package App\BuildingBlocks\ActionGenerator
 *
 * Generates basic validation rules base of given generic types and filed name
 *
 */
class TypesValidationRulesGenerator
{
    private string $fieldLowerCase;

    public function __construct(private string $field, private array $types)
    {
        $this->fieldLowerCase = strtolower($this->field);
    }

    public function rules(): array
    {
        if (empty($this->types)) {
            return [];
        }

        $rules = [];

        if ($this->hasType('null')) {
            $rules[] = 'nullable';
        } else {
            $rules[] = 'required';
        }

        // we will stop the generator if the field accept array for now
        if ($this->hasType('array')) {
            $rules[] = 'array';
            return $rules;
        }

        if (
            $this->hasType(['string', 'int'])
            || $this->hasType(['string', 'float'])
            || $this->hasType(['string', 'double'])
        ) {
            $rules[] = 'alpha_num';
        } elseif ($this->hasType(['int', 'float', 'double'], false)) {
            $rules[] = 'numeric';
        } elseif ($this->hasType('string')) {
            $rules[] = 'string';
        } elseif ($this->hasType('bool')) {
            $rules[] = 'boolean';
        }

        if ($this->fieldContains('id')) {
            $rules[] = 'uuid';
        } elseif ($this->fieldContains('email')) {
            $rules[] = 'email';
        } elseif ($this->fieldContains('date')) {
            $rules[] = 'date';
        } elseif ($this->fieldContains('accepted')) {
            $rules[] = 'accepted';
        } elseif ($this->fieldContains('slug')) {
            $rules[] = 'slug';
        }

        return $rules;
    }

    private function fieldContains(string $word): bool
    {
        return str_contains($this->fieldLowerCase, $word);
    }

    private function hasType(string|array $type, $matchAll = true): bool
    {
        if (\is_string($type)) {
            return \in_array($type, $this->types, $matchAll);
        }

        $foundNum = count(array_intersect($type, $this->types));
        if ($matchAll) {
            return $foundNum === count($type);
        }

        return $foundNum > 0;
    }
}