<?php

namespace Thormeier\SlidesGeneratorBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Thormeier\SlidesGeneratorBundle\Generator\SlidesGenerator;
use Thormeier\SlidesGeneratorBundle\Generator\SlidesGeneratorInterface;

/**
 * Class SlidesGenerateCommand
 */
class SlidesGenerateCommand extends Command
{
    /**
     * @var SlidesGeneratorInterface
     */
    private $generator;

    /**
     * SlidesGenerateCommand constructor.
     *
     * @param SlidesGeneratorInterface $generator
     */
    public function __construct(SlidesGeneratorInterface $generator)
    {
        $this->generator = $generator;
        parent::__construct();
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('slides:generate')
            ->setDescription('Generates slides from a configured repository and renders them with a configured renderer');

        $options = $this->generator->getOptions();

        foreach ($options as $option) {
            $this->addArgument($option);
        }
    }

    /**
     * Executes the current command.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return int exit status
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var SlidesGenerator $generator */
        $renderedSlides = $this->generator->generate($input->getArguments());
        $output->write($renderedSlides);
    }
}
