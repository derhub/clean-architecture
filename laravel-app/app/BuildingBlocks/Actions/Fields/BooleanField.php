<?php

namespace App\BuildingBlocks\Actions\Fields;

class BooleanField extends BaseField
{
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->addPayloadModifier(
            function ($payload) {
                if ($payload === null) {
                    return null;
                }

                return in_array(
                    $payload,
                    ['1', 1, true, 'true', 'yes'],
                    true
                );
            }
        );
    }

    public static function fromReplace(BaseField $field): self
    {
        $self = new self($field->all());

        $type = ['bool'];
        $rule = ['boolean'];

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
