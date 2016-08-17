<?php

namespace Thormeier\SlidesGeneratorBundle\Tests\Unit\Renderer;

use Thormeier\SlidesGeneratorBundle\Model\Slide;
use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;
use Thormeier\SlidesGeneratorBundle\Renderer\MarkdownRenderer;

/**
 * Class MarkdownRendererTest
 */
class MarkdownRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the correct rendering of markdown slides
     */
    public function testRender()
    {
        $slide1 = new Slide('foo', 'lorem ipsum');
        $slide2 = new Slide('bar', 'dolor sit amet');

        $collection = new SlideCollection();
        $collection->addSlide($slide1)
            ->addSlide($slide2);

        $renderer = new MarkdownRenderer();

        $expectedResult = "----------\nfoo\n\nlorem ipsum\n----------\nbar\n\ndolor sit amet\n----------";

        $this->assertEquals($expectedResult, $renderer->render($collection));
    }
}
