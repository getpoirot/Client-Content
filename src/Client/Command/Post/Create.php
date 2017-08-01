<?php
namespace Poirot\ContentClient\Client\Command\Post;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;
use Poirot\ContentClient\Client\Command\tTokenAware;
use Poirot\Std\Hydrator\HydrateGetters;


class Create
    implements iApiCommand
    , \IteratorAggregate
{
    use tCommandHelper;
    use tTokenAware;


    /**
     * Constructor.
     *
     */
    function __construct()
    {

    }


    // Options



    // ..

    function getIterator()
    {
        $hydrate = new HydrateGetters($this);
        return $hydrate->getIterator();
    }
}
