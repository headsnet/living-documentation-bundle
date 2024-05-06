<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Services;

use Symfony\Contracts\EventDispatcher\Event;

final class PublishDocumentation extends Event
{
    public function __construct(
        private readonly array $data,
        private readonly string $namespace,
        private readonly string $context,
        private readonly string $outDir
    ) {
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getOutDir(): string
    {
        return $this->outDir;
    }
}
