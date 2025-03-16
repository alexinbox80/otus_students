<?php

namespace Support\Helper;

use InvalidArgumentException;
use ReflectionException;
use ReflectionClass;

class SetEntityId
{
    /**
     * @param mixed $entity
     * @param int $returnId
     * @return void
     * @throws ReflectionException
     */
    public static function updateEntityId(mixed $entity, int $returnId): void
    {
        if (!is_object($entity)) {
            throw new InvalidArgumentException('Provided entity is not an object');
        }

        $reflection = new ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $returnId);
    }
}
