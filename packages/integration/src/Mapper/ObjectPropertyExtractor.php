<?php

namespace Derhub\Integration\Mapper;

use ReflectionClass;

class ObjectPropertyExtractor
{
    private ExtractorCacheHelper $propertyNameConverter;
    private ExtractorCacheHelper $propertyMethod;
    private mixed $allowAccess;

    public function __construct(ExtractorCacheHelper $propertyNameConverter)
    {
        $this->allowAccess = false;
        $this->propertyNameConverter = $propertyNameConverter;

        $this->propertyMethod = new ExtractorCacheHelper(
            static function ($propertyName, $object) {
                // when property is protected & private
                // we will try to check for method to get the value
                // supported prefix 'is', 'get'
                // example: getName(), isSold()

                // fluent getter method
                if (method_exists($object, $propertyName)) {
                    return $propertyName;
                }

                // method with prefix get
                $getter = 'get'.$propertyName;
                if (method_exists($object, $getter)) {
                    return $getter;
                }

                // method with prefix is
                $getter = 'is'.$propertyName;
                if (method_exists($object, $getter)) {
                    return $getter;
                }

                return null;
            }
        );
    }

    public function setAllowPrivateProtectedAccess($allow = true): void
    {
        $this->allowAccess = $allow;
    }

    public function extract(object $object): array
    {
        $refClass = new ReflectionClass($object);
        $props = $refClass->getProperties(
            \ReflectionProperty::IS_PUBLIC
            | \ReflectionProperty::IS_PRIVATE
            | \ReflectionProperty::IS_PROTECTED
        );

        $results = [];
        foreach ($props as $property) {
            $propertyName = $property->getName();
            $fieldName = $this->propertyNameConverter
                    ->extract($propertyName, 'extract') ?? $propertyName;

            // get property from public class
            if ($property->isPublic()) {
                $results[$fieldName] = $object->{$propertyName};
                continue;
            }

            $method = $this->propertyMethod->extract($propertyName, $object);
            if ($method) {
                $results[$fieldName] = $object->{$method}();
                continue;
            }

            if ($this->allowAccess) {
                $property->setAccessible(true);
                $results[$fieldName] = $property->getValue($object);
            }
        }

        return $results;
    }
}
