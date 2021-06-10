<?php

namespace App\BuildingBlocks\Actions\Fields;

class NumericFiled extends BaseField
{
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->addPayloadModifier(
            function ($payload) {
                if ($payload === null) {
                    return null;
                }

                if (\is_int($payload) || \is_float($payload)) {
                    return $payload;
                }

                if (\in_array('float', $this->types())) {
                    return (float)$payload;
                }

                return (int)$payload;
            }
        );
    }

    public static function fromReplace(BaseField $field): self
    {
        $self = new self($field->all());

        $type = ['int'];
        $rule = ['numeric'];

        if (! $self->required()) {
            $rule[] = 'nullable';
            $type[] = 'null';
        }

        $self->setTypes($type)
            ->setValidationRules($rule)
        ;

        return $self;
    }
}