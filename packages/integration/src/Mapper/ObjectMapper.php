<?php

namespace Derhub\Integration\Mapper;

use Derhub\Shared\ObjectMapper\ObjectMapperInterface;
use ReflectionClass;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;

/**
 * Class Mapper for POPO
 * @package Derhub\Shared\Hydrator
 *
 * transform:
 *  - it extract parameters from construct using ReflectionClass
 *  - fill each parameter with value from data
 *  - instantiate class
 *  - it also automatically resolve class with fromArray, fromString, fromInt and fromBool method
 *
 * @example $map->transform(['test1'=> 1], TestClass::class) // returns new TestClass(test1: 1);
 *
 * extract:
 *  - extract class values to array
 *  - it only extract public
 *  - it can also extract private & protect if it has getter in fluent format
 *
 * @example $map->extract(new TestClass(test1: 1)); // returns ['test1' => 1];
 */
class ObjectMapper implements ObjectMapperInterface
{
    private const GENERIC_TYPE_METHODS = [
        'string' => 'fromString',
        'integer' => 'fromInt',
        'array' => 'fromArray',
        'double' => 'fromDouble',
        'boolean' => 'fromBoolean',
        'object' => 'fromObject',
        'NULL' => 'fromNull',
        'resource' => 'fromResource',
        'unknown type' => null,
        'resource (closed)' => null,
    ];
    protected array $fieldNames = [];
    protected array $fieldResolvers = [];
    protected array $resolver = [];
    private ExtractorCacheHelper $getFieldName;
    /**
     * @var callable|null
     */
    private $propertyNameConverter;
    /**
     * @var \Derhub\Integration\Mapper\ExtractorCacheHelper
     */
    private ExtractorCacheHelper $propNameMapper;

    public function __construct(?callable $propertyNameConverter = null)
    {
        $this->propertyNameConverter = $propertyNameConverter;

        $this->propNameMapper = $this->createPropertyExtractor();
    }

    private function createPropertyExtractor(): ExtractorCacheHelper
    {
        return new ExtractorCacheHelper(
            function ($propertyName) {
                if ($getFieldName = $this->propertyNameConverter) {
                    return $getFieldName($propertyName);
                }

                return $this->fieldNames[$propertyName] ?? $propertyName;
            }
        );
    }

    private function dataHasValue(object|array $data, string $key): bool
    {
        return is_array($data) ? isset($data[$key]) : isset($data->{$key});
    }

    /**
     * @return iterable<string>
     */
    private function extractParamTypes(
        null|ReflectionType|ReflectionUnionType $paramType
    ): iterable {
        if (! $paramType) {
            yield null;
        }

        if ($paramType instanceof ReflectionUnionType) {
            foreach ($paramType->getTypes() as $type) {
                yield (string)$type;
            }
        }

        if ($paramType instanceof ReflectionType) {
            yield (string)$paramType;
        }

        yield null;
    }

    /**
     * @param object|string $object
     * @return \ReflectionClass
     *
     * @throws \ReflectionException
     */
    private function getClassReflection(object|string $object): ReflectionClass
    {
        return new ReflectionClass($object);
    }

    private function getDataValue(object|array $data, string $key): mixed
    {
        return is_array($data) ? $data[$key] : $data->{$key};
    }

    private function resolveFieldValue(
        ReflectionParameter $parameter,
        mixed $data,
        string $name,
        string $propertyName,
    ): mixed {
        $value = $this->getDataValue($data, $name);

        /** @var callable|string $resolver */
        $resolver = $this->fieldResolvers[$propertyName] ?? null;

        if ($resolver === null) {
            if ($result = $this->tryToAutoResolve($parameter, $value)) {
                return $result;
            }

            throw InvalidTypeException::unableToResolveProperty($propertyName);
        }

        if (is_object($value) && $value instanceof $resolver) {
            return $value;
        }

        if (is_callable($resolver)) {
            return $resolver($value);
        }

        // look for defined resolver
        $valueResolver = $this->resolver[$resolver] ?? null;

        if ($valueResolver === null) {
            throw InvalidTypeException::missingResolver($name, $resolver);
        }

        $array = is_array($valueResolver) && count($valueResolver) === 2;
        if ($array) {
            [$className, $method] = $valueResolver;
            if ($value instanceof $className) {
                return $value;
            }

            return call_user_func([$className, $method], $value);
        }

        if (is_callable($valueResolver)) {
            return $valueResolver($value);
        }

        // auto resolve class string
//        if (class_exists($resolver)) {
//            $value = !is_array($value) ? [$property => $value] : $value;
//            return $this->transform($value, $resolver);
//        }

        throw InvalidTypeException::notSupportedResolver($name, $resolver);
    }

    /**
     * @param class-string $name
     * @param array|string|callable $resolver
     */
    public function defineResolver(
        string $name,
        array|string|callable $resolver
    ): void {
        $this->resolver[$name] = $resolver;
    }

    public function defineResolverWithSameMethod(
        string $method,
        array $classNames,
    ): void {
        foreach ($classNames as $className) {
            $this->defineResolver($className, [$className, $method]);
        }
    }

    /**
     * Extract public, private and protected property
     * Getter method is required for protected and private property
     * Static and cons are ignored
     *
     * @param object $object
     * @return array
     */
    public function extract(object $object): array
    {
        $extractor = new ObjectPropertyExtractor($this->propNameMapper);

        return $extractor->extract($object);
    }

    /**
     * @return \ReflectionParameter[]
     * @throws \ReflectionException
     */
    final public function extractConstructorParameter(
        string $object
    ): array {
        $refClass = $this->getClassReflection($object);
        $constructor = $refClass->getConstructor();
        if (! $constructor || $constructor->getNumberOfParameters() === 0) {
            throw InvalidTypeException::missingConstructor($object);
        }

        return $constructor->getParameters();
    }

    public function mapMetaData(
        string $name,
        string $property,
        string|callable $resolver = null
    ): void {
        $this->fieldNames[$property] = $name;
        if ($resolver !== null) {
            $this->fieldResolvers[$property] = $resolver;
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function transform(object|array $data, string $object): mixed
    {
        $params = [];
        $props = $this->extractConstructorParameter($object);

        foreach ($props as $param) {
            $propertyName = $param->getName();
            $name = $this->propNameMapper->extract($propertyName);
            $hasValue = $this->dataHasValue($data, $name);
            if (! $hasValue) {
                // for required parameter maybe we should throw exception
                // but for now just let the class handle that
                continue;
            }

            $params[$propertyName] = $this->resolveFieldValue(
                $param,
                $data,
                $name,
                $propertyName,
            );
        }

        return new $object(...$params);
    }

    protected function getFieldNameFromPropertyName(string $objPropName): string
    {
        return $this->getFieldName->extract($objPropName);
    }

    protected function getPossibleMethod(mixed $type): ?string
    {
        return self::GENERIC_TYPE_METHODS[$type] ?? null;
    }

    /**
     * For now this only support generic and class types with fromGeneric format
     * e.g
     * $value = 'string...';
     * then it will try to resolve using method fromString($value)
     * @param \ReflectionParameter $param
     * @param mixed $value
     * @return mixed
     */
    protected function tryToAutoResolve(
        ReflectionParameter $param,
        mixed $value
    ): mixed {
        if ($value === null && $param->allowsNull()) {
            return null;
        }

        $paramType = $param->getType();
        $allTypes = $this->extractParamTypes($paramType);
        $valueType = gettype($value);
        foreach ($allTypes as $paramTypeStr) {
            if ($paramTypeStr === null) {
                continue;
            }

            if ($valueType === $paramTypeStr) {
                return $value;
            }

            // check if same instance
            if (is_object($value) && $value instanceof $paramTypeStr) {
                return $value;
            }

            if (! class_exists($paramTypeStr)) {
                continue;
            }

            $possibleMethod = $this->getPossibleMethod($valueType);
            if ($possibleMethod === null
                || ! method_exists($paramTypeStr, $possibleMethod)) {
                // unable to get possible method base on value type
                continue;
            }

            return call_user_func([$paramTypeStr, $possibleMethod], $value);
        }

        // one of union type is not generic throw an error saying its not supported
        if ($paramType instanceof ReflectionUnionType) {
            throw InvalidTypeException::autoResolveUnionTypeNoSupported(
                $param->getName()
            );
        }

        // just return the value and let the class decide how to handle it
        return $value;
    }
}
