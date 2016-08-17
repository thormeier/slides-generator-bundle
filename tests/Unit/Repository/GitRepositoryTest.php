<?php

namespace Thormeier\SlidesGeneratorBundle\Tests\Unit\Repository;

use PHPGit\Git;
use Thormeier\SlidesGeneratorBundle\Model\Slide;
use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;
use Thormeier\SlidesGeneratorBundle\Repository\GitRepository;

/**
 * Class GitRepositoryTest
 */
class GitRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Identifier pattern to get the title out of the commit message
     */
    const PATTERN = '/(TICKET-[0-9]+)/';

    /**
     * Keyword that is omitted in the slides and indicates a commit message that should be used for a slide
     */
    const KEYWORD = ':slides';

    /**
     * Format used for commit datetimes
     */
    const DATE_FORMAT = 'D, d M Y H:i:s O';

    /**
     * Tests getting of slides with a mocked Git client
     *
     * @param array           $commits
     * @param SlideCollection $slides
     * @param array           $options
     *
     * @dataProvider getSlidesProvider
     */
    public function testGetSlides(array $commits, SlideCollection $slides, array $options)
    {
        /** @var Git|\PHPUnit_Framework_MockObject_MockObject $git */
        $git = $this->getMockBuilder(Git::class)
            ->getMock();

        $git->expects($this->once())
            ->method('__call')
            ->will($this->returnValue($commits));

        $repository = new GitRepository($git, self::PATTERN, self::KEYWORD);

        $this->assertEquals($slides, $repository->getSlides($options));
    }

    /**
     * Data provider method for testGetSlides
     *
     * @return array
     */
    public function getSlidesProvider()
    {
        $slide1 = new Slide('TICKET-1234', 'foo');
        $slide2 = new Slide('TICKET-5678', 'baz' . "\n" . 'bar');
        $slide3 = new Slide('TICKET-9012', 'qux');

        $emptyCollection           = new SlideCollection();
        $collectionOneSlide        = SlideCollection::fromArray(array($slide1));
        $collectionTwoSlides       = SlideCollection::fromArray(array($slide2, $slide1));
        $collectionThreeSlides     = SlideCollection::fromArray(array($slide3, $slide2, $slide1));
        $collectionOneSlideFromOne = SlideCollection::fromArray(array($slide2));

        $commitSlideOne = $this->createCommit(
            '1',
            'example',
            'example@example.com',
            new \DateTime('2016-08-01 12:00:00'),
            'TICKET-1234 foo :slides'
        );
        $commitSlideTwoOne = $this->createCommit(
            '1',
            'example',
            'example@example.com',
            new \DateTime('2016-08-02 12:00:00'),
            'TICKET-5678 bar :slides'
        );
        $commitSlideTwoTwo = $this->createCommit(
            '1',
            'example',
            'example@example.com',
            new \DateTime('2016-08-03 12:00:00'),
            'TICKET-5678 baz :slides'
        );
        $commitNoSlide = $this->createCommit(
            '1',
            'example',
            'example@example.com',
            new \DateTime('2016-08-04 12:00:00'),
            'TICKET-5678 baz'
        );
        $commitSlideThree = $this->createCommit(
            '1',
            'example',
            'example@example.com',
            new \DateTime('2016-08-05 12:00:00'),
            'TICKET-9012 qux :slides'
        );

        return array(
            array(array(), $emptyCollection, array()),
            array(array($commitNoSlide), $emptyCollection, array()),
            array(array($commitSlideOne), $collectionOneSlide, array()),
            array(array($commitSlideTwoTwo, $commitSlideTwoOne, $commitSlideOne), $collectionTwoSlides, array()),
            array(array($commitSlideTwoTwo, $commitNoSlide, $commitSlideTwoOne, $commitSlideOne), $collectionTwoSlides, array()),
            array(array($commitSlideThree, $commitSlideTwoTwo, $commitSlideTwoOne, $commitSlideOne), $collectionThreeSlides, array()),
            array(array($commitSlideOne, $commitSlideTwoOne, $commitSlideTwoTwo, $commitSlideThree), $emptyCollection, array('from' => '2017-01-01 00:00:01')),
            array(array($commitSlideTwoTwo, $commitSlideTwoOne, $commitSlideOne), $collectionOneSlideFromOne, array('from' => '2016-08-02 00:00:01')),
            array(array($commitSlideOne), $collectionOneSlide, array('limit' => 1)),
        );
    }

    /**
     * @param string    $hash
     * @param string    $name
     * @param string    $email
     * @param \DateTime $dateTime
     * @param string    $title
     *
     * @return array
     */
    private function createCommit($hash, $name, $email, \DateTime $dateTime, $title)
    {
        return array(
            'hash' => $hash,
            'name' => $name,
            'email' => $email,
            'date' => $dateTime->format(self::DATE_FORMAT),
            'title' => $title,
        );
    }
}
