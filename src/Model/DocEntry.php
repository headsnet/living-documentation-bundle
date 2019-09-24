<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Model;

use Headsnet\LivingDocumentation\Annotation\LivingDocumentationAnnotation;

/**
 * Represents the data from a single documentation annotation in the source code
 */
final class DocEntry
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $shortClass;

    /**
     * @var LivingDocumentationAnnotation
     */
    private $annotation;

    /**
     * @param string                        $class
     * @param string                        $shortClass
     * @param LivingDocumentationAnnotation $annotation
     */
    public function __construct(string $class, string $shortClass, LivingDocumentationAnnotation $annotation)
    {
        $this->class = $class;
        $this->shortClass = $shortClass;
        $this->annotation = $annotation;
    }

    /**
     * @return string
     */
    public function class(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function shortClass(): string
    {
        return $this->shortClass;
    }

    /**
     * @return LivingDocumentationAnnotation
     */
    public function annotation(): LivingDocumentationAnnotation
    {
        return $this->annotation;
    }
}
