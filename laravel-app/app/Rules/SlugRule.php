<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SlugRule implements Rule
{
    public const NAME = 'slug';

    /**
     * user when extending validation
     *
     * @param ...$args
     * @return bool
     */
    public function validate(...$args): bool
    {
        return $this->passes(...$args);
    }

    public function passes($attribute, $value): bool
    {
        return \Derhub\Shared\Utils\Str::slug($value) === $value;
    }

    public function message(): string
    {
        return trans('validation.slug');
    }
}
