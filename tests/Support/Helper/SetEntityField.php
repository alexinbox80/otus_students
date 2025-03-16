<?php

namespace Support\Helper;

use InvalidArgumentException;
use ReflectionException;
use ReflectionClass;

class SetEntityField
{
    /**
     * @param mixed $entity
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws ReflectionException
     */
    public static function updateEntityField(mixed $entity, string $field, mixed $value): void
    {
        if (!is_object($entity)) {
            throw new InvalidArgumentException('Provided entity is not an object');
        }

        $reflection = new ReflectionClass($entity);
        $property = $reflection->getProperty($field);
        $property->setAccessible(true);
        $property->setValue($entity, $value);
    }
}
