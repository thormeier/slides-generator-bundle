<?php

namespace Thormeier\SlidesGeneratorBundle\Model;

/**
 * Class SlideCollection
 */
class SlideCollection
{
    /**
     * @var Slide[]
     */
    private $slides = array();

    /**
     * Static constructor
     *
     * @param array $slides
     *
     * @return SlideCollection
     */
    public static function fromArray(array $slides)
    {
        $instance = new self;
        /** @var Slide $slide */
        foreach ($slides as $slide) {
            $instance->addSlide($slide);
        }

        return $instance;
    }

    /**
     * Adds a slide to the collection
     *
     * @param Slide $slide
     *
     * @return $this
     */
    public function addSlide(Slide $slide)
    {
        if (strlen($slide->getIdentifier()) > 0 && null !== $this->getSlideByIdentifier($slide->getIdentifier())) {
            throw new \LogicException(
                sprintf('Slide with identifier "%s" already exists',
                $slide->getIdentifier()
            ));
        }

        $this->slides[] = $slide;

        return $this;
    }

    /**
     * Get a slide by a specific identifier
     *
     * @param string $identifier
     *
     * @return null|Slide
     */
    public function getSlideByIdentifier($identifier)
    {
        foreach ($this->slides as $slide) {
            if ($identifier === $slide->getIdentifier()) {
                return $slide;
            }
        }

        return null;
    }

    /**
     * @return Slide[]
     */
    public function getAll()
    {
        return $this->slides;
    }
}
