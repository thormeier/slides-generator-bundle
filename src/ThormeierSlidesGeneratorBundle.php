<?php

namespace Thormeier\SlidesGeneratorBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Thormeier\SlidesGeneratorBundle\DependencyInjection\GeneratorCompilerPass;

/**
 * Bundle class
 *
 * @codeCoverageIgnore
 */
class ThormeierSlidesGeneratorBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GeneratorCompilerPass());
    }
}
