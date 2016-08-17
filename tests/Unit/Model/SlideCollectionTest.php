<?php

namespace Thormeier\SlidesGeneratorBundle\Tests\Unit\Model;

use Thormeier\SlidesGeneratorBundle\Model\Slide;
use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;

/**
 * Class SlideCollectionTest
 */
class SlideCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests all possible cases of adding and getting slides
     */
    public function testAddSlides()
    {
        $idOne = '1';
        $slideOne = new Slide($idOne);

        $idTwo = '2';
        $slideTwo = new Slide($idTwo);

        $collection = new SlideCollection();

        $this->assertEmpty($collection->getAll());
        $this->assertNull($collection->getSlideByIdentifier($idOne));
        $this->assertNull($collection->getSlideByIdentifier($idTwo));

        $collection->addSlide($slideOne);

        $this->assertEquals($slideOne, $collection->getSlideByIdentifier($idOne));
        $this->assertNull($collection->getSlideByIdentifier($idTwo));

        $collection->addSlide($slideTwo);

        $this->assertEquals($slideOne, $collection->getSlideByIdentifier($idOne));
        $this->assertEquals($slideTwo, $collection->getSlideByIdentifier($idTwo));

        $this->setExpectedException(\LogicException::class);

        $collection->addSlide($slideOne);
    }

    /**
     * Tests the creation of a collection by an array of slides
     */
    public function testFromArray()
    {
        $idOne = '1';
        $slideOne = new Slide($idOne);

        $idTwo = '2';
        $slideTwo = new Slide($idTwo);

        $slides = array($slideOne, $slideTwo);

        $collection = SlideCollection::fromArray($slides);

        $this->assertEquals($slides, $collection->getAll());
    }
}
