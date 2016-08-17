<?php

namespace Thormeier\SlidesGeneratorBundle\Model;

/**
 * Represents a single slide
 */
class Slide
{
    /**
     * @var string To identify this slide, might either be ticket number or something else
     */
    private $identifier;

    /**
     * @var string Message in this slide.
     */
    private $message = '';

    /**
     * Slide constructor.
     *
     * @param string $identifier
     * @param string $message
     */
    public function __construct($identifier, $message = '')
    {
        $this->identifier = $identifier;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $additionalMessage
     *
     * @return $this
     */
    public function appendToMessage($additionalMessage)
    {
        $this->message .= $additionalMessage;

        return $this;
    }

    /**
     * Returns the slides message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
