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
        array $payload,
        array $rules,
    ): \Illuminate\Validation\Validator {
        return Validator::make($payload, $rules);
    }

    public function validate(array $payload): \Illuminate\Validation\Validator
    {
        return $this->askForValidator(
            $payload,
            $this->validationRules($payload)
        );
    }

    public function validationRules(array $payload): array
    {
        $fields = static::fields($payload);

        $rulesByFiled = [];
        foreach ($fields as $field => $config) {
            [
                'rules' => $rules,
                'alias' => $alias,
            ] = $config;

            $hidden = $config['hidden'] ?? false;
            if ($hidden) {
                continue;
            }


            // the field can be alias(snake case) or field name(camel case)
            // to support both we will set the default rule key to alias
            // and then only use field name if its in payload

            $key = $alias;
            if (isset($payload[$field])) {
                $key = $field;
            }

            $rulesByFiled[$key] = $rules;
        }

        return $rulesByFiled;
    }
}
