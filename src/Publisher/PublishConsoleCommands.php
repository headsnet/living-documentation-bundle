<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Publisher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Publish a list of available console commands
 */
final class PublishConsoleCommands extends BasePublisher implements EventSubscriberInterface
{
    protected string $template = 'console-commands';
}
