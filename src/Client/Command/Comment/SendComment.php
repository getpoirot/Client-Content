<?php
namespace Poirot\ContentClient\Client\Command\Comment;

use MongoDB\BSON\ObjectID;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ContentClient\Client\Command\tTokenAware;
use Poirot\ContentClient\Entity\LocationObject;
use Poirot\Std\Hydrator\HydrateGetters;


class SendComment
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

    /** @var string */
    protected $content;

    /** @var string */
    protected $contentId;

    /**
     * Constructor.
     *
     * @param string $content
     * @param ObjectID $contentId
     */
    function __construct($content,ObjectID $contentId) {
        $this->content = $content;
        $this->contentId = $contentId;
    }


    // Options


    /**
     * @return array|\Traversable
     */
    function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    function getContentId()
    {
        return $this->contentId;
    }

    // ..

    /**
     * @ignore
     * @return \Traversable
     */
    function getIterator()
    {
        $hydrate = new HydrateGetters($this);
        $hydrate->setExcludeNullValues();
        return $hydrate->getIterator();
    }
}
