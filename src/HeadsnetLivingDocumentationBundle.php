<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class HeadsnetLivingDocumentationBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        // load an XML, PHP or YAML file
        $container->import('../config/services.xml');

        /*// you can also add or replace parameters and services
        $container->parameters()
            ->set('acme_hello.phrase', $config['phrase'])
        ;

        if ($config['scream']) {
            $container->services()
                ->get('acme_hello.printer')
                ->class(ScreamingPrinter::class)
            ;
        }*/
    }
}
