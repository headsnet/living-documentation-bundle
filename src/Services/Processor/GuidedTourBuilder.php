<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Services\Processor;

use Headsnet\LivingDocumentation\Annotation\CuratedContent\GuidedTour;
use Headsnet\LivingDocumentationBundle\Model\DocEntry;

final class GuidedTourBuilder
{
    public function getTourNames(array $data): array
    {
        return array_unique(array_map(function (DocEntry $docEntry): string {
            /** @var GuidedTour $attribute */
            $attribute = $docEntry->attribute();

            return $attribute->getName();
        }, $data['CuratedContent_GuidedTour'] ?? []));
    }

    /**
     * @param array<DocEntry> $data
     */
    public function getTourWaypoints(array $data, string $tour): array
    {
        return $tourData = array_filter(
            $data['CuratedContent_GuidedTour'],
            fn (DocEntry $docEntry) => $docEntry->attribute()
                ->getName() === $tour
        );
    }

    /**
     * @param array<DocEntry> $tourWaypoints
     */
    public function sortTourWaypoints(array $tourWaypoints): array
    {
        usort($tourWaypoints, function (DocEntry $a, DocEntry $b) {
            if ($a->attribute()->getRank() == $b->attribute()->getRank()) {
                return 0;
            }

            return ($a->attribute()->getRank() < $b->attribute()->getRank()) ? -1 : 1;
        });

        return $tourWaypoints;
    }
}
