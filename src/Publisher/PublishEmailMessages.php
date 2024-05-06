<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Publisher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Publish a list of email messages sent
 */
final class PublishEmailMessages extends BasePublisher implements EventSubscriberInterface
{
    protected string $template = 'email-messages';
}
