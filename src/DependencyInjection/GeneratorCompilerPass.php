<?php

namespace Thormeier\SlidesGeneratorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class Compiler pass to configure service dependencies
 *
 * @codeCoverageIgnore
 */
class GeneratorCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('thormeier_slides_generator.generator')
            ->setArguments(array(
                new Reference($container->getParameter('thormeier_slides_generator.service.repository')),
                new Reference($container->getParameter('thormeier_slides_generator.service.renderer')),
            ));
        $container->getDefinition('thormeier_slides_generator.command.generate')
            ->setArguments(array(
                new Reference($container->getParameter('thormeier_slides_generator.service.generator')),
            ));
    }
}
