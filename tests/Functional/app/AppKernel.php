<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Simple AppKernel for tests
 */
class AppKernel extends Kernel
{
    /**
     * Registers the SlidesGeneratorBundle and the FrameworkBundle
     *
     * @return array
     */
    public function registerBundles()
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Thormeier\SlidesGeneratorBundle\ThormeierSlidesGeneratorBundle(),
        );
    }

    /**
     * Load mocked config
     *
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.php');
    }
}
