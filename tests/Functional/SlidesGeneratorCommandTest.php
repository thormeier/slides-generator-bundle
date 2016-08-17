<?php

namespace Thormeier\SlidesGeneratorBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class SlidesGeneratorCommandTest
 */
class SlidesGeneratorCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $application;

    /**
     * Sets up the AppKernel and a console application
     */
    protected function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
    }

    /**
     * Test running of command
     */
    public function testRunCommand()
    {
        $output = new NullOutput();
        $input = new ArrayInput(array(
            0 => 'slides:generate',
        ));
        $exitCode = $this->application->run($input, $output);

        $this->assertSame(0, $exitCode);
    }
}
