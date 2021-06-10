<?php

namespace App\BuildingBlocks\Actions\Fields;

class ArrayField extends BaseField
{
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->addPayloadModifier(
            function ($payload) {
                if ($payload === null) {
                    return null;
                }

                if (! is_array($payload)) {
                    return [$payload];
                }

                return $payload;
            }
        );
    }

    public static function fromReplace(BaseField $field): self
    {
        $self = new self($field->all());

        $prevType = $field->types();
        $type = ['array'];
        $rule = ['array'];

        if (! $self->required()) {
            $rule[] = 'nullable';
            $type[] = 'null';
        }

        if (\in_array('int', $prevType, true)) {
            $type[] = 'int';
        }

        if (\in_array('string', $prevType, true)) {
            $type[] = 'string';
        }

        if (\in_array('bool', $prevType, true)) {
            $type[] = 'bool';
        }


        $self->setTypes($type)
            ->setValidationRules($rule)
        ;

        return $self;
    }
}
