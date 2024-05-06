<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Model;

use Headsnet\LivingDocumentation\Annotation\LivingDocumentationAnnotation;

/**
 * Represents the data from a single documentation attribute in the source code
 */
final readonly class DocEntry
{
    public function __construct(
        private string $class,
        private string $shortClass,
        private LivingDocumentationAnnotation $attribute
    ) {
    }

    public function class(): string
    {
        return $this->class;
    }

    public function shortClass(): string
    {
        return $this->shortClass;
    }

    public function attribute(): LivingDocumentationAnnotation
    {
        return $this->attribute;
    }
}
