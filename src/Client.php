<?php
namespace Poirot\ContentClient;

use Poirot\ContentClient\Client\Command;
use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\ApiClient\aClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ContentClient\Client\PlatformRest;
use Poirot\ContentClient\Entity\PostContentObject;
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

    /**
     * Create a Post Content
     *
     * @param PostContentObject $content
     *
     * @return array
     */
    function create(PostContentObject $content)
    {
        $response = $this->call(
            new Command\Post\Create(
                $content->getContentType()
                , $content->getContent()
                , $content->getStat()
                , $content->getShare()
                , $content->getIsCommentEnabled()
                , $content->getLocation()
            )
        );

        if ( $ex = $response->hasException() )
            throw $ex;

        $r = $response->expected();
        $r = $r->get('result');
        return $r;
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
