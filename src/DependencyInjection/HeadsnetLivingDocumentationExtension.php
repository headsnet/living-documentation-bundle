<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HeadsnetLivingDocumentationExtension extends Extension implements PrependExtensionInterface
{
    #[\Override]
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.xml');
    }

    #[\Override]
    public function prepend(ContainerBuilder $container)
    {
        if (! $container->hasExtension('twig')) {
            return;
        }

        $path = dirname(__DIR__, 1) . '/../templates';

        $container->prependExtensionConfig('twig', [
            'paths' => [$path],
        ]);
    }
}
