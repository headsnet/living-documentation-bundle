<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Services\Processor;

use Headsnet\LivingDocumentation\Annotation\CuratedContent\GuidedTour;
use Headsnet\LivingDocumentationBundle\Model\DocEntry;

/**
 * Class
 */
final class GuidedTourBuilder
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function getTourNames(array $data): array
    {
        $tours = array_unique(array_map(function (DocEntry $docEntry)
        {
            /** @var GuidedTour $annotation */
            $annotation = $docEntry->annotation();

            return $annotation->getName();
        }, $data['CuratedContent_GuidedTour'] ?? []));

        return $tours;
    }

    /**
     * @param DocEntry[] $data
     * @param string     $tour
     *
     * @return array
     */
    public function getTourWaypoints(array $data, $tour): array
    {
        return $tourData = array_filter($data['CuratedContent_GuidedTour'], function (DocEntry $docEntry) use ($tour)
        {
            return $docEntry->annotation()->getName() === $tour;
        });
    }

    /**
     * @param DocEntry[] $tourWaypoints
     *
     * @return array
     */
    public function sortTourWaypoints(array $tourWaypoints): array
    {
        usort($tourWaypoints, function (DocEntry $a, DocEntry $b) {
            if ($a->annotation()->getRank() == $b->annotation()->getRank())
            {
                return 0;
            }

            return ($a->annotation()->getRank() < $b->annotation()->getRank()) ? -1 : 1;
        });

        return $tourWaypoints;
    }
}
