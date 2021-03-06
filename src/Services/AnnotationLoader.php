<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Services;

use HaydenPierce\ClassFinder\ClassFinder;
use Headsnet\LivingDocumentation\Annotation\LivingDocumentationAnnotation;
use Headsnet\LivingDocumentationBundle\Event\PublishDocumentation;
use Headsnet\LivingDocumentationBundle\Model\DocEntry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class
 */
final class AnnotationLoader
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $projectDir
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, string $projectDir)
    {
        $this->projectDir = $projectDir;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $namespace
     * @param string $context
     * @param string $outDir
     *
     * @throws \Exception
     */
    public function load(string $namespace, string $context, string $outDir)
    {
        $classes = ClassFinder::getClassesInNamespace($namespace, ClassFinder::RECURSIVE_MODE);

        $reader = new AnnotationReader();
        $data = [];

        foreach ($classes as $inspectedClass)
        {
            $annotations = $reader->getClass($inspectedClass);
            $inspectedClass = str_replace($namespace, '', $inspectedClass);

            foreach($annotations as $annotation)
            {
                if ($annotation instanceof LivingDocumentationAnnotation)
                {
                    $key = str_replace('\\', '_',
                           str_replace('Headsnet\LivingDocumentation\Annotation\\', '',
                               get_class($annotation))
                    );

                    $shortName = (new \ReflectionClass($namespace.$inspectedClass))->getShortName();

                    $data[$key][] = new DocEntry($inspectedClass, $shortName, $annotation);
                }
            }
        }

        $event = new PublishDocumentation($data, $namespace, $context, $outDir);
        $this->eventDispatcher->dispatch($event);
    }
}
