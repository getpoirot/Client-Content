<?php
namespace Poirot\ContentClient\Client\Command\Comment;

use MongoDB\BSON\ObjectID;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ContentClient\Client\Command\tTokenAware;
use Poirot\ContentClient\Entity\LocationObject;
use Poirot\Std\Hydrator\HydrateGetters;


class DeleteComment
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

    /** @var string */
    protected $contentId;

    /** @var string */
    protected $commentId;

    /**
     * Constructor.
     *
     * @param ObjectID $commentId
     * @param ObjectID $contentId
     */
    function __construct(ObjectID $contentId,ObjectID $commentId) {
        $this->contentId = $contentId;
        $this->commentId = $commentId;
    }


    // Options


    /**
     * @return string
     */
    function getContentId()
    {
        return $this->contentId;
    }

    /**
     * @return array|\Traversable
     */
    function getCommentId()
    {
        return $this->commentId;
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
