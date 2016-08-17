<?php

namespace Thormeier\SlidesGeneratorBundle\Repository;

use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;

/**
 * Interface SlideRepositoryInterface
 */
interface SlideRepositoryInterface
{
    /**
     * Returns slides
     *
     * @param array $options
     *
     * @return SlideCollection
     */
    public function getSlides(array $options);

    /**
     * Get all possible options
     *
     * @return array
     */
    public function getOptions();
}
