<?php
namespace Poirot\ContentClient\Entity;

use Poirot\Std\Struct\aValueObject;


class GeoObject
    extends aValueObject
{
    protected $lat;
    protected $lon;
}