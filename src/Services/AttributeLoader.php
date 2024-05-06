<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Services;

use HaydenPierce\ClassFinder\ClassFinder;
use Headsnet\LivingDocumentationBundle\Model\DocEntry;
use ReflectionAttribute;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final readonly class AttributeLoader
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function load(string $namespace, string $context, string $outDir): void
    {
        $classes = ClassFinder::getClassesInNamespace($namespace, ClassFinder::RECURSIVE_MODE);

        $data = [];

        foreach ($classes as $inspectedClass) {
            $attributes = AttributeReader::getClass($inspectedClass);

            /** @var ReflectionAttribute $attribute */
            foreach ($attributes as $attribute) {
                if (str_contains($attribute->getName(), 'Headsnet\LivingDocumentation\Annotation')) {
                    $key = str_replace(
                        '\\',
                        '_',
                        str_replace(
                            'Headsnet\LivingDocumentation\Annotation\\',
                            '',
                            $attribute->getName()
                        )
                    );

                    $shortName = (new \ReflectionClass($inspectedClass))->getShortName();

                    $data[$key][] = new DocEntry($inspectedClass, $shortName, $attribute->newInstance());
                }
            }
        }

        dump($data);

        $event = new PublishDocumentation($data, $namespace, $context, $outDir);
        $this->eventDispatcher->dispatch($event);
    }
}
