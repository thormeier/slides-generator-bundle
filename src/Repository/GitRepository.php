<?php

namespace Thormeier\SlidesGeneratorBundle\Repository;

use PHPGit\Git;
use Thormeier\SlidesGeneratorBundle\Model\Slide;
use Thormeier\SlidesGeneratorBundle\Model\SlideCollection;

/**
 * Class GitRepository
 */
class GitRepository implements SlideRepositoryInterface
{
    /**
     * @var Git
     */
    private $git;

    /**
     * @var string
     */
    private $patternIdentifier;

    /**
     * @var string
     */
    private $keywordAdd;

    /**
     * GitRepository constructor.
     *
     * @param Git    $git
     * @param string $patternIdentifier
     * @param string $keywordAdd
     */
    public function __construct(Git $git, $patternIdentifier, $keywordAdd)
    {
        $this->git = $git;
        $this->patternIdentifier = $patternIdentifier;
        $this->keywordAdd = $keywordAdd;
    }

    /**
     * Returns slides
     *
     * @param array $options
     *
     * @return SlideCollection
     */
    public function getSlides(array $options)
    {
        $dateLimit = isset($options['from']) ? new \DateTime($options['from']) : null;
        $commitLimit = isset($options['limit']) ? $options['limit'] : 200;

        return $this->createSlides($this->getCommits($dateLimit, $commitLimit));
    }

    /**
     * Gets at most $limit commits from $dateTime on
     *
     * @param \DateTime|null $dateLimit
     * @param int            $limit
     *
     * @return array
     */
    private function getCommits(\DateTime $dateLimit = null, $limit = 200)
    {
        $commits = $this->git->log(null, array('limit' => $limit));

        if (null === $dateLimit) {
            return $commits;
        }

        $filteredCommits = array();

        foreach ($commits as $commit) {
            if (false === $this->isFuture($dateLimit, new \DateTime($commit['date']))) {
                break; // Break as soon as $dateLimit is reached
            }

            $filteredCommits[] = $commit;
        }

        return $filteredCommits;
    }

    /**
     * Creates a collection of slides, ready to render, from an array of commits
     *
     * @param array $commits
     *
     * @return SlideCollection
     */
    private function createSlides(array $commits)
    {
        $slideCollection = new SlideCollection();

        $identifierRegexPattern = '/' . trim($this->patternIdentifier, '/') . '/';

        foreach ($commits as $commit) {
            if (strpos($commit['title'], $this->keywordAdd) !== false) {
                // Get the identifier out of the commit message
                preg_match($identifierRegexPattern, $commit['title'], $slideIdentifiers);
                $identifier = isset($slideIdentifiers[0]) ? $slideIdentifiers[0] : null;

                // Get the plain message out of the commit message
                $message = trim(str_replace($this->keywordAdd, '', preg_replace($identifierRegexPattern, '', $commit['title'])));

                if (null !== $identifier) {
                    if ($slide = $slideCollection->getSlideByIdentifier($identifier)) {
                        $slide->appendToMessage("\n" . $message);
                    } else {
                        $slideCollection->addSlide(new Slide($identifier, $message));
                    }
                }
            }
        }

        return $slideCollection;
    }

    /**
     * Determines if $dateTime is in the future of $fixPoint
     *
     * @param \DateTime $fixPoint
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    private function isFuture(\DateTime $fixPoint, \DateTime $dateTime)
    {
        return $dateTime->diff($fixPoint)->invert === 1;
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
        return array('from', 'limit');
    }
}
