<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Publisher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Publish a list of use-cases (application service commands)
 */
final class PublishUseCases extends BasePublisher implements EventSubscriberInterface
{
    protected string $template = 'use-cases';
}
