<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Tests\Unit\Services;

use Headsnet\LivingDocumentation\Annotation\DDD\ApplicationService;
use Headsnet\LivingDocumentation\Annotation\DDD\CoreConcept;
use Headsnet\LivingDocumentation\Annotation\DDD\Invariant;
use Headsnet\LivingDocumentationBundle\Services\AttributeReader;
use Headsnet\LivingDocumentationBundle\Tests\Util\Entity\CargoShipment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionAttribute;

#[CoversClass(AttributeReader::class)]
final class AttributeReaderTest extends TestCase
{
    #[Test]
    public function can_read_class_attributes(): void
    {
        $class = new CargoShipment();

        $classAttributes = AttributeReader::getClass(get_class($class));

        $this->assertCount(1, $classAttributes);
        /** @var ReflectionAttribute $attribute */
        $attribute = $classAttributes[0];
        $this->assertEquals(CoreConcept::class, $attribute->getName());
    }

    #[Test]
    public function can_read_method_attributes(): void
    {
        $class = new CargoShipment();

        $classAttributes = AttributeReader::getMethod(get_class($class), 'someAction');

        $this->assertCount(1, $classAttributes);
        /** @var ReflectionAttribute $attribute */
        $attribute = $classAttributes[0];
        $this->assertEquals(Invariant::class, $attribute->getName());
        $this->assertEquals('Cannot be less than 5 units', $attribute->getArguments()[0]);
    }

    #[Test]
    public function can_read_property_attributes(): void
    {
        $class = new CargoShipment();

        $classAttributes = AttributeReader::getProperty(get_class($class), 'description');

        $this->assertCount(1, $classAttributes);
        /** @var ReflectionAttribute $attribute */
        $attribute = $classAttributes[0];
        $this->assertEquals(ApplicationService::class, $attribute->getName());
        $this->assertEquals('Calculates the value of the description', $attribute->getArguments()[0]);
    }
}
