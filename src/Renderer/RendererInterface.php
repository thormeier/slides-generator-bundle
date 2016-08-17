<?php

namespace Thormeier\SlidesGeneratorBundle\Renderer;

use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;

/**
 * Class RendererInterface
 */
interface RendererInterface
{
    /**
     * Renders the given slides to a specific format
     *
     * @param SlideCollection $slides
     *
     * @return string
     */
    public function render(SlideCollection $slides);

    /**
     * Get all possible options
     *
     * @return array
     */
    public function getOptions();
}
