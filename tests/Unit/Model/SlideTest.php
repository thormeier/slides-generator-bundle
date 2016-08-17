<?php

namespace Thormeier\SlidesGeneratorBundle\Tests\Unit\Model;

use Thormeier\SlidesGeneratorBundle\Model\Slide;

/**
 * Class SlideTest
 */
class SlideTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the setup of a slide
     */
    public function testSetUp()
    {
        $identifier = 'foo';
        $message = 'bar';

        $slide = new Slide($identifier, $message);

        $this->assertEquals($identifier, $slide->getIdentifier());
        $this->assertEquals($message, $slide->getMessage());
    }

    /**
     * Test the appending of something to the message
     */
    public function testAppendMessage()
    {
        $identifier = 'foo';
        $message = 'bar';
        $messagePartTwo = 'baz';

        $slide = new Slide($identifier, $message);

        $this->assertEquals($message, $slide->getMessage());

        $slide->appendToMessage($messagePartTwo);

        $this->assertEquals($message . $messagePartTwo, $slide->getMessage());
    }
}
