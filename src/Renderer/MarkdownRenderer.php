<?php

namespace Thormeier\SlidesGeneratorBundle\Renderer;

use Thormeier\SlidesGeneratorBundle\Model\Slide;
use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;

/**
 * Class MarkdownRenderer
 */
class MarkdownRenderer implements RendererInterface
{
    const SEPARATOR = '----------';

    /**
     * Renders the given slides to a specific format
     *
     * @param SlideCollection $slides
     *
     * @return string
     */
    public function render(SlideCollection $slides)
    {
        $renderedSlides = array_map(array($this, 'renderSlide'), $slides->getAll());

        return
            self::SEPARATOR
            . "\n"
            . implode("\n" . self::SEPARATOR . "\n", $renderedSlides)
            . "\n"
            . self::SEPARATOR;
    }

    /**
     * Renders a slide
     *
     * @param Slide $slide
     *
     * @return string
     */
    private function renderSlide(Slide $slide)
    {
        $renderedSlide = '';
        if (strlen($slide->getIdentifier()) > 0) {
            $renderedSlide .= $slide->getIdentifier() . "\n\n";
        }

        $renderedSlide .= $slide->getMessage();

        return $renderedSlide;
    }

    /**
     * Get all possible options
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function getOptions()
    {
        return array('files');
    }
}
