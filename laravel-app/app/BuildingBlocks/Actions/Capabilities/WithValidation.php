<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use Validator;

trait WithValidation
{
    /**
     * Return true if pass false if not
     *
     * @param array $payload
     * @param array $rules
     * @return \Illuminate\Validation\Validator
     */
    public function askForValidator(
        iterable $payload,
        array $rules,
    ): \Illuminate\Validation\Validator {
        return Validator::make($payload, $rules);
    }

    public function validate(
        iterable $payload
    ): \Illuminate\Validation\Validator {
        return $this->askForValidator(
            $payload,
            $this->validationRules($payload)
        );
    }

    public function validationRules(iterable $payload): array
    {
        $fields = static::getComputedFields();

        $rulesByFiled = [];

        /** @var \App\BuildingBlocks\Actions\Fields\BaseField $config */
        foreach ($fields as $field => $config) {
            if ($config->hidden()) {
                continue;
            }


            // the field can be alias(snake case) or field name(camel case)
            // to support both we will set the default rule key to alias
            // and then only use field name if its in payload

            $key = $config->alias();
            if (isset($payload[$field])) {
                $key = $field;
            }

            $rulesByFiled[$key] = $config->validationRules();
        }

        return $rulesByFiled;
    }
}
