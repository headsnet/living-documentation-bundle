<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Publisher;

use Headsnet\LivingDocumentationBundle\Services\PublishDocumentation;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Error\Error;

abstract class BasePublisher
{
    protected string $template;

    public function __construct(
        protected Environment $twig
    ) {
    }

    /**
     * @return array<string, array<string>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PublishDocumentation::class => ['build'],
        ];
    }

    public function build(PublishDocumentation $event): void
    {
        if (empty($this->template)) {
            throw new \Exception('Publisher template must be specified!');
        }

        try {
            $markdown = $this->twig->render(sprintf('%s.html.twig', $this->template), [
                'data' => $event->getData(),
                'namespace' => $event->getNamespace(),
            ]);
        }
        catch (Error $e) {
            die('Error rendering output template:' . $e->getMessage());
        }

        $filesystem = new Filesystem();

        $filesystem->dumpFile(
            sprintf('%s%s/%s.md', $event->getOutDir(), $event->getContext(), $this->template),
            $markdown
        );
    }
}
