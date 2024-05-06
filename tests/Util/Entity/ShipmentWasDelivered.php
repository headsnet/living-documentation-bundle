<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Tests\Util\Entity;

use Headsnet\LivingDocumentation\Annotation\DDD\CoreConcept;

#[CoreConcept('Dispatched when a shipment is delivered to its destination')]
final class ShipmentWasDelivered
{
}
