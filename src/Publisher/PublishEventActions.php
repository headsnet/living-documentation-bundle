<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Publisher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Publish a list of event actions (EventHandlers)
 */
final class PublishEventActions extends BasePublisher implements EventSubscriberInterface
{
    protected string $template = 'event-actions';
}
