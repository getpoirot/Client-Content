<?php
namespace Poirot\ContentClient;

use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\ApiClient\aClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ContentClient\Client\PlatformRest;
use Poirot\ContentClient\Exceptions\exTokenMismatch;


class Client
    extends aClient
{
    protected $serverUrl;
    protected $platform;
    protected $tokenProvider;


    /**
     * Content Client constructor.
     *
     * @param string         $serverUrl
     * @param iTokenProvider $tokenProvider
     */
    function __construct($serverUrl, iTokenProvider $tokenProvider)
    {
        $this->serverUrl  = rtrim( (string) $serverUrl, '/' );
        $this->tokenProvider = $tokenProvider;
    }


    // Implement aClient

    /**
     * Get Client Platform
     *
     * - used by request to build params for
     *   server execution call and response
     *
     * @return iPlatform
     */
    protected function platform()
    {
        if (! $this->platform )
            $this->platform = new PlatformRest;


        # Default Options Overriding
        $this->platform->setServerUrl( $this->serverUrl );

        return $this->platform;
    }


    // ..

    /**
     * @override handle token renewal from server
     *
     * @inheritdoc
     */
    protected function call(iApiCommand $command)
    {
        $recall = 1;

        recall:

        if (method_exists($command, 'setToken')) {
            $token = $this->tokenProvider->getToken();
            $command->setToken($token);
        }


        $response = parent::call($command);

        if ($ex = $response->hasException()) {

            if ( $ex instanceof exTokenMismatch && $recall > 0 ) {
                // Token revoked or mismatch
                // Refresh Token
                $this->tokenProvider->exchangeToken();
                $recall--;

                goto recall;
            }

            throw $ex;
        }


        return $response;
    }
}
