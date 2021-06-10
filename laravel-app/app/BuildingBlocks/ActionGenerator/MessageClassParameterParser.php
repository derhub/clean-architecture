<?php

namespace App\BuildingBlocks\ActionGenerator;

use Arr;
use Derhub\Shared\Utils\Str;
use Generator;
use ReflectionClass;
use ReflectionParameter;

/**
 * Class MessageParameterParser
 * @package App\BuildingBlocks\ActionGenerator
 *
 * Extract message class constructor parameters
 * fields:
 * [
 *  'name' => [
 *          'reflectionParam' => \ReflectionParameter,
 *          'required' => bool, // true if parameter dont have default value
 *          'name' => string,
 *          'alias' => string, // snake case of name
 *          'types' => array, // example: ['null', 'array', 'int'] or ['string']
 *          'default' => mixed, // the default value, The parser can only support: 'integer', 'boolean', 'string', 'double'
 *      ],
 * ]
 *
 * notes:
 *  - provide complicated values in generator config file. example: array "default" value ['default' => [1,2,3,4]]
 *
 */
class MessageClassParameterParser
{
    private array $config;

    public static function for(string $message): self
    {
        try {
            $refClass = new ReflectionClass($message);
        } catch (\ReflectionException $e) {
            return new self($message, []);
        }

        $constructor = $refClass->getConstructor();
        if (! $constructor) {
            return new self($message, []);
        }

        if ($constructor->getNumberOfParameters() === 0) {
            return new  self($message, []);
        }

        return new self($message, $constructor->getParameters());
    }

    public function __construct(private string $message, private array $params)
    {
        $this->config = config('derhub.generator.parameters');
    }

    public function params(): Generator
    {
        $parameterProvider = Arr::get($this->config, $this->message, []);

        /** @var \ReflectionParameter $param */
        foreach ($this->params as $param) {
            $data = $parameterProvider[$param->name] ?? [];

            $type = (string)$param->getType();

            // fill the missing fields in config
            $data['reflectionParam'] = $param;
            $data['name'] ??= $param->name;
            $data['alias'] ??= Str::snake($param->name);
            $data['types'] ??= explode('|', str_replace('?', 'null|', $type));
            $data['required'] ??= ! $param->isOptional()
                && ! $param->isDefaultValueAvailable();
            $data['default'] ??= $this->getDefaultValue($param);

            if ($param->isOptional()
                && $param->isDefaultValueAvailable()
                && ! \in_array('null', $data['types'], true)) {
                $data['types'][] = 'null';
            }

            yield $param->name => $data;
        }
    }

    private function getDefaultValue(
        ReflectionParameter $param
    ): null|string|int {
        if (! $param->isDefaultValueAvailable()) {
            return null;
        }

        try {
            $value = $param->getDefaultValue();

            if (is_array($value)) {
                return null;
            }

            if ($value === null) {
                return 'null';
            }

            $handleTypes = ['integer', 'boolean', 'string', 'double'];
            $type = gettype($value);

            if (! in_array($type, $handleTypes)) {
                return null;
            }

            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }

            return $value;
        } catch (\ReflectionException $e) {
        }

        return null;
    }
}
