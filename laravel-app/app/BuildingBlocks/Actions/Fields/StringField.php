<?php

namespace App\BuildingBlocks\Actions\Fields;

class StringField extends BaseField
{
    public function __construct(array $config)
    {
        $config['required'] ??= false;
        $config['types'] ??= ['string'];
        $config['rules'] ??= ['nullable', 'string'];

        parent::__construct($config);
    }

    public static function fromReplace(BaseField $field): self
    {
        $self = new self($field->all());

        $type = ['string'];
        $rule = ['string'];

        if (! $self->required()) {
            $rule[] = 'nullable';
            $type[] = 'null';
        }

        $self->setTypes($type)
            ->setValidationRules($rule)
        ;

        return $self;
    }

    public function openApiSchema(): array
    {
        $schema = [
            'type' => 'string',
            'required' => $this->required(),
            'nullable' => \in_array('null', $this->types(), true),
        ];

        if ($this->default() !== null) {
            $schema['default'] = $this->default();
        }

        if (! empty($this->options())) {
            $schema['enum'] = \array_values($this->options());
        }

        return $schema;
    }
}
