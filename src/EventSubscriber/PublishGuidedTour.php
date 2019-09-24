<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\EventSubscriber;

use Cocur\Slugify\Slugify;
use Headsnet\LivingDocumentationBundle\Event\PublishDocumentation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Error\Error;

/**
 * Publish Guided Tour documentation
 */
final class PublishGuidedTour extends BasePublisher implements EventSubscriberInterface
{
    protected $template = 'guided-tour';

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
            $tours = $this->getTourNames($event->getData());

            $slugify = new Slugify();

            foreach ($tours as $tour)
            {
                $tourWaypoints = $this->sortTourWaypoints(
                    $this->getTourWaypoints($event->getData(), $tour)
                );

                $markdown = $this->twig->render(sprintf('%s.html.twig', $this->template), [
                    'data' => $tourWaypoints,
                    'namespace' => $event->getNamespace(),
                    'tour' => $tour
                ]);

                $filesystem = new Filesystem();

                $filesystem->dumpFile(
                    sprintf(
                        '%s%s/%s/%s.md',
                        $event->getOutDir(),
                        $event->getContext(),
                        $this->template, $slugify->slugify($tour)
                    ),
                    $markdown
                );
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
     * @param array $data
     *
     * @return array
     */
    private function getTourNames(array $data): array
    {
        $tours = array_unique(array_map(function (array $guidedTour) {
            return $guidedTour['annotation']->getName();
        }, $data['CuratedContent_GuidedTour']));

        return $tours;
    }

    /**
     * @param PublishDocumentation $event
     * @param                      $tour
     *
     * @return array
     */
    private function getTourWaypoints(array $data, $tour): array
    {
        return $tourData = array_filter($data['CuratedContent_GuidedTour'], function (array $tourWaypoint) use ($tour)
        {
            return $tourWaypoint['annotation']->getName() === $tour;
        });
    }

    /**
     * @return array
     */
    private function sortTourWaypoints($tourWaypoints): array
    {
        usort($tourWaypoints, function (array $a, array $b) {
            if ($a['annotation']->getRank() == $b['annotation']->getRank())
            {
                return 0;
            }

            return ($a['annotation']->getRank() < $b['annotation']->getRank()) ? -1 : 1;
        });

        return $tourWaypoints;
    }
}
