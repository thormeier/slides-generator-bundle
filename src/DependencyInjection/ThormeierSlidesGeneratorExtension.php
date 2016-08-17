<?php

namespace Thormeier\SlidesGeneratorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * DI extension
 *
 * @codeCoverageIgnore
 */
class ThormeierSlidesGeneratorExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('thormeier_slides_generator', $config);

        $container->setParameter('thormeier_slides_generator.identifier_pattern', $config['identifier_pattern']);
        $container->setParameter('thormeier_slides_generator.keyword_add', $config['keyword_add']);
        $container->setParameter('thormeier_slides_generator.service.repository', $config['repository_service']);
        $container->setParameter('thormeier_slides_generator.service.renderer', $config['renderer_service']);
        $container->setParameter('thormeier_slides_generator.service.generator', $config['generator_service']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
