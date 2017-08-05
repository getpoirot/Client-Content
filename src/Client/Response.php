<?php
namespace Poirot\ContentClient\Client;

use Poirot\ApiClient\Exceptions\exHttpResponse;
use Poirot\ApiClient\Response\ExpectedJson;
use Poirot\ApiClient\ResponseOfClient;
use Poirot\ContentClient\Exceptions\exResourceNotFound;
use Poirot\ContentClient\Exceptions\exTokenMismatch;
use Poirot\ContentClient\Exceptions\exUnexpectedValue;
use Poirot\ContentClient\Exceptions\exUnknownContentType;


class Response
    extends ResponseOfClient
{
    /**
     * Has Exception?
     *
     * @return \Exception|false
     */
    function hasException()
    {
        if ($this->exception instanceof exHttpResponse) {
            // Determine Known Errors ...
            $expected = $this->expected();
            if ($expected && $err =  $expected->get('error') ) {
                switch ($err['state']) {
                    case 'exOAuthAccessDenied':
                        $this->exception = new exTokenMismatch($err['message'], (int) $err['code']);
                        break;    
                    case 'exUnexpectedValue':
                        $this->exception = new exUnexpectedValue($err['message'], (int) $err['code']);
                        break;
                    case 'exUnknownContentType':
                        $this->exception = new exUnknownContentType($err['message'], (int) $err['code']);
                        break;
                    case 'exResourceNotFound':
                        $this->exception = new exResourceNotFound($err['message'], (int) $err['code']);
                        break;
                }
            }
        }

        return $this->exception;
    }

    /**
     * Process Raw Body As Result
     *
     * :proc
     * mixed function($originResult, $self);
     *
     * @param callable $callable
     *
     * @return mixed
     */
    function expected(/*callable*/ $callable = null)
    {
        if ( $callable === null )
            // Retrieve Json Parsed Data Result
            $callable = $this->_getDataParser();


        return parent::expected($callable);
    }


    // ...

    function _getDataParser()
    {
        if ( false !== strpos($this->getMeta('content_type'), 'application/json') )
            // Retrieve Json Parsed Data Result
            return new ExpectedJson;


        return null;
    }
}
