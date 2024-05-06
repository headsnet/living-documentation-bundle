<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Tests\Util\Entity;

use Headsnet\LivingDocumentation\Annotation\DDD\ApplicationService;
use Headsnet\LivingDocumentation\Annotation\DDD\CoreConcept;
use Headsnet\LivingDocumentation\Annotation\DDD\Invariant;

#[CoreConcept('A container that is moved from point A to point B')]
final class CargoShipment
{
    #[ApplicationService('Calculates the value of the description')]
    public string $description;

    public string $propertyWithoutAnAttribute;

    #[Invariant('Cannot be less than 5 units')]
    public function someAction(): void
    {
    }

    public function methodWithoutAnAttribute(): void
    {
    }
}
