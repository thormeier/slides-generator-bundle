<?php

namespace Thormeier\SlidesGeneratorBundle\Generator;

use Thormeier\SlidesGeneratorBundle\Renderer\RendererInterface;
use Thormeier\SlidesGeneratorBundle\Repository\SlideRepositoryInterface;

/**
 * Class SlidesGenerator
 */
class SlidesGenerator implements SlidesGeneratorInterface
{
    /**
     * @var SlideRepositoryInterface
     */
    private $repository;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * SlidesGenerator constructor.
     *
     * @param SlideRepositoryInterface $repository
     * @param RendererInterface        $renderer
     */
    public function __construct(SlideRepositoryInterface $repository, RendererInterface $renderer)
    {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    /**
     * Generates slides by an array of options
     *
     * @param array $options
     *
     * @return string
     */
    public function generate(array $options)
    {
        return $this->renderer->render($this->repository->getSlides($options));
    }

    /**
     * Returns options of both the repository and the renderer
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge($this->repository->getOptions(), $this->renderer->getOptions());
    }
}
