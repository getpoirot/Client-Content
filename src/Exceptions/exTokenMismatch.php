<?php
namespace Poirot\ContentClient\Exceptions;

use Poirot\ApiClient\Exceptions\Response\exServerAuthorizationDeniedAccess;


class exTokenMismatch
    extends exServerAuthorizationDeniedAccess
    implements iExceptionOfContentClient
{

}
