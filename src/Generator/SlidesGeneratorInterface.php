<?php

namespace Thormeier\SlidesGeneratorBundle\Generator;

/**
 * Class SlidesGeneratorInterface
 */
interface SlidesGeneratorInterface
{
    /**
     * Generates slides by an array of options
     *
     * @param array $options
     *
     * @return string
     */
    public function generate(array $options);

    /**
     * Returns options of both the repository and the renderer
     *
     * @return array
     */
    public function getOptions();
}
