<?php

namespace Thormeier\SlidesGeneratorBundle\Tests\Unit\Generator;

use Thormeier\SlidesGeneratorBundle\Generator\SlidesGenerator;
use Thormeier\SlidesGeneratorBundle\Model\Slide;
use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;
use Thormeier\SlidesGeneratorBundle\Renderer\RendererInterface;
use Thormeier\SlidesGeneratorBundle\Repository\SlideRepositoryInterface;

/**
 * Class SlidesGeneratorTest
 */
class SlidesGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SlideRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repository;

    /**
     * @var RendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var SlidesGenerator
     */
    private $generator;

    /**
     * Sets up the generator and its dependencies
     */
    public function setUp()
    {
        /** @var SlideRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $repository */
        $this->repository = $this->getMockBuilder(SlideRepositoryInterface::class)
            ->setMethods(['getOptions', 'getSlides'])
            ->getMockForAbstractClass();

        /** @var RendererInterface|\PHPUnit_Framework_MockObject_MockObject $renderer */
        $this->renderer = $this->getMockBuilder(RendererInterface::class)
            ->setMethods(['getOptions', 'render'])
            ->getMockForAbstractClass();

        $this->generator = new SlidesGenerator($this->repository, $this->renderer);
    }

    /**
     * Tests the getting of options
     */
    public function testGetOptions()
    {
        $optionsRepository = array('foo' => 'bar', 'baz' => 'qux');
        $optionsRenderer = array('bar' => 'foo', 'qux' => 'baz');

        $this->repository->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue($optionsRepository));

        $this->renderer->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue($optionsRenderer));

        $expectedOptions = array_merge($optionsRepository, $optionsRenderer);

        $this->assertEquals($expectedOptions, $this->generator->getOptions());
    }

    /**
     * Tests the correct chaining of getting slides and rendering them
     */
    public function testGenerate()
    {
        $slide = new Slide('TICKET-1234', 'foobar');
        $expectedPassedCollection = SlideCollection::fromArray(array($slide));
        $expectedOutcome = 'foobar';

        $expectedPassedOptions = array('foo' => 'bar');

        $this->repository->expects($this->once())
            ->method('getSlides')
            ->will($this->returnCallback(function ($passedOptions) use ($expectedPassedOptions, $expectedPassedCollection) {
                $this->assertEquals($expectedPassedOptions, $passedOptions);

                return $expectedPassedCollection;
            }));

        $this->renderer->expects($this->once())
            ->method('render')
            ->will($this->returnCallback(function ($passedValue) use ($expectedPassedCollection, $expectedOutcome) {
                $this->assertEquals($expectedPassedCollection, $passedValue);

                return $expectedOutcome;
            }));

        $this->assertEquals($expectedOutcome, $this->generator->generate($expectedPassedOptions));
    }
}
