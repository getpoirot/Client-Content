<?php
namespace Poirot\ContentClient\Client\Command\Post;

use MongoDB\BSON\ObjectID;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ContentClient\Client\Command\tTokenAware;
use Poirot\Std\Hydrator\HydrateGetters;


class UserLikes
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;

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
