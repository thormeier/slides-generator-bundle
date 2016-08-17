<?php

namespace Thormeier\SlidesGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * DI configuration
 *
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('thormeier_slides_generator');

        $rootNode
            ->children()
                ->scalarNode('identifier_pattern')->isRequired()->end()
                ->scalarNode('keyword_add')->defaultValue(':slides')->end()
                ->scalarNode('repository_service')->defaultValue('thormeier_slides_generator.repository.git')->end()
                ->scalarNode('renderer_service')->defaultValue('thormeier_slides_generator.renderer.markdown')->end()
                ->scalarNode('generator_service')->defaultValue('thormeier_slides_generator.generator')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
