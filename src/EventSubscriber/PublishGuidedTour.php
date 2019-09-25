<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\EventSubscriber;

use Cocur\Slugify\Slugify;
use Headsnet\LivingDocumentationBundle\Event\PublishDocumentation;
use Headsnet\LivingDocumentationBundle\Services\Processor\GuidedTourBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Error\Error;

/**
 * Publish Guided Tour documentation
 */
final class PublishGuidedTour extends BasePublisher implements EventSubscriberInterface
{
    protected $template = 'guided-tour';

    /**
     * @var GuidedTourBuilder
     */
    private $builder;

    /**
     * @param Environment       $twig
     * @param GuidedTourBuilder $builder
     */
    public function __construct(Environment $twig, GuidedTourBuilder $builder)
    {
        parent::__construct($twig);

        $this->builder = $builder;
    }

    /**
     * @param PublishDocumentation $event
     *
     * @throws \Exception
     */
    public function build(PublishDocumentation $event)
    {
        if (empty($this->template))
        {
            throw new \Exception('Publisher template must be specified!');
        }

        try
        {
            $tours = $this->builder->getTourNames($event->getData());

            foreach ($tours as $tour)
            {
                $tourWaypoints = $this->builder->sortTourWaypoints(
                    $this->builder->getTourWaypoints($event->getData(), $tour)
                );

                $this->writeMarkdownFile($event, $tourWaypoints, $tour);
                $this->writePumlFile($event, $tourWaypoints, $tour);
            }
        }
        catch (Error $exception)
        {
            die('Error rendering output template:' . $exception->getMessage());
        }
        catch (IOException $exception)
        {
            die('Error writing output file:' . $exception->getMessage());
        }
    }

    /**
     * @param PublishDocumentation $event
     * @param array                $tourWaypoints
     * @param                      $tour
     *
     * @throws Error
     */
    private function writeMarkdownFile(PublishDocumentation $event, array $tourWaypoints, $tour): void
    {
        $markdown = $this->twig->render(sprintf('%s.html.twig', $this->template), [
            'data'      => $tourWaypoints,
            'namespace' => $event->getNamespace(),
            'tour'      => $tour
        ]);

        (new Filesystem())->dumpFile(
            sprintf(
                '%s%s/%s/%s.md',
                $event->getOutDir(),
                $event->getContext(),
                $this->template, (new Slugify())->slugify($tour)
            ),
            $markdown
        );
    }

    /**
     * @param PublishDocumentation $event
     * @param array                $tourWaypoints
     * @param                      $tour
     *
     * @throws Error
     */
    private function writePumlFile(PublishDocumentation $event, array $tourWaypoints, $tour): void
    {
        $markdown = $this->twig->render(sprintf('diagram/%s.puml.twig', $this->template), [
            'data'      => $tourWaypoints,
            'namespace' => $event->getNamespace(),
            'tour'      => $tour
        ]);

        (new Filesystem())->dumpFile(
            sprintf(
                '%s%s/%s/%s.puml',
                $event->getOutDir(),
                $event->getContext(),
                $this->template,
                (new Slugify())->slugify($tour)
            ),
            $markdown
        );
    }
}
