<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Publisher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Publish a glossary document for the specified context
 */
final class PublishGlossary extends BasePublisher implements EventSubscriberInterface
{
    protected string $template = 'glossary';
}
