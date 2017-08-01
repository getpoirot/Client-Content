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


    protected $contentType;
    protected $content;
    protected $location;
    protected $stat  = self::STAT_PUBLISH;
    protected $share = self::SHARE_PUBLIC;
    protected $isCommentEnabled = true;


}
