<?php
namespace Poirot\ContentClient\Client\Command\Post;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ContentClient\Client\Command\tTokenAware;
use Poirot\ContentClient\Entity\LocationObject;
use Poirot\Std\Hydrator\HydrateGetters;


class Create
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

    /** @var string */
    protected $contentType;
    /** @var array|\Traversable */
    protected $content;
    /** @var string */
    protected $stat;
    /** @var string */
    protected $share;
    /** @var bool */
    protected $isCommentEnabled;
    /** @var LocationObject */
    protected $location;


    /**
     * Constructor.
     *
     * @param string             $contentType
     * @param array|\Traversable $content
     * @param string             $stat
     * @param string             $share
     * @param bool               $isCommentEnabled
     * @param LocationObject     $location
     */
    function __construct(
        $contentType
        , $content
        , $stat = 'publish'
        , $share = 'public'
        , $isCommentEnabled = true
        , LocationObject $location = null
    ) {
        $this->contentType = $contentType;
        $this->content = $content;
        $this->stat = $stat;
        $this->share = $share;
        $this->isCommentEnabled = $isCommentEnabled;
        $this->location = $location;
    }


    // Options

    /**
     * @return string
     */
    function getContentType()
    {
        return $this->contentType;
    }

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
    function getStat()
    {
        return $this->stat;
    }

    /**
     * @return string
     */
    function getShare()
    {
        return $this->share;
    }

    /**
     * @return boolean
     */
    function getIsCommentEnabled()
    {
        return $this->isCommentEnabled;
    }

    /**
     * @return LocationObject
     */
    function getLocation()
    {
        return $this->location;
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
