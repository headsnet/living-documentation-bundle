<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Services;

class AttributeReader
{
    public static function getClass(string $classString): array
    {
        $class = new \ReflectionClass($classString);

        return $class->getAttributes();
    }

    public static function getMethod(string $classString, string $methodString): array
    {
        $class = new \ReflectionClass($classString);
        $methods = $class->getMethods();

        $methodAttributes = [];
        foreach ($methods as $method) {
            if ($method->getName() !== $methodString) {
                continue;
            }

            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {
                $methodAttributes[] = $attribute;
            }
        }

        return $methodAttributes;
    }

    public static function getProperty(string $classString, string $propertyString): array
    {
        $class = new \ReflectionClass($classString);
        $properties = $class->getProperties();

        $propertyAttributes = [];
        foreach ($properties as $property) {
            if ($property->getName() !== $propertyString) {
                continue;
            }

            $attributes = $property->getAttributes();
            foreach ($attributes as $attribute) {
                $propertyAttributes[] = $attribute;
            }
        }

        return $propertyAttributes;
    }
}
