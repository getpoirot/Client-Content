<?php
namespace Poirot\ContentClient\Entity;

use Poirot\Std\Struct\aValueObject;


class PostContentObject
    extends aValueObject
{
    const STAT_PUBLISH = 'publish';
    const STAT_DRAFT   = 'draft';
    const STAT_LOCKED  = 'locked';

    const SHARE_PUBLIC  = 'public';
    const SHARE_PRIVATE = 'private';


    private $_allowed_stat = [
        'publish' => true,
        'draft'   => true,
        'locked'  => true,
    ];

    private $_allowed_share = [
        'public'  => true,
        'private' => true,
    ];


    protected $contentType;
    protected $content;
    protected $location;
    protected $stat  = self::STAT_PUBLISH;
    protected $share = self::SHARE_PUBLIC;
    protected $isCommentEnabled = true;


    /**
     * @return string
     */
    function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    function setContentType($contentType)
    {
        $this->contentType = (string) $contentType;
    }

    /**
     * @return mixed
     */
    function getContent()
    {
        return $this->content;
    }

    /**
     * @param array|\Traversable $content
     */
    function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return LocationObject
     */
    function getLocation()
    {
        return $this->location;
    }

    /**
     * @param LocationObject $location
     */
    function setLocation(LocationObject $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    function getStat()
    {
        return $this->stat;
    }

    /**
     * @param string $stat
     * @throws \Exception
     */
    function setStat($stat)
    {
        $stat = strtolower((string) $orig = $stat);
        if (! isset($this->_allowed_stat[$stat]) )
            throw new \Exception(sprintf(
                'Stat (%s) Is Undefined.'
                , $orig
            ));

        $this->stat = (string) $stat;
    }

    /**
     * @return string
     */
    function getShare()
    {
        return $this->share;
    }

    /**
     * @param string $share
     * @throws \Exception
     */
    function setShare($share)
    {
        $share = strtolower((string) $orig = $share);
        if (! isset($this->_allowed_share[$share]) )
            throw new \Exception(sprintf(
                'Share Stat (%s) Is Undefined.'
                , $orig
            ));

        $this->share = (string) $share;
    }

    /**
     * @return boolean
     */
    function getIsCommentEnabled()
    {
        return $this->isCommentEnabled;
    }

    /**
     * @param boolean $isCommentEnabled
     */
    function setIsCommentEnabled($isCommentEnabled)
    {
        $this->isCommentEnabled = (bool) $isCommentEnabled;
    }
}
