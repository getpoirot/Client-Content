<?php

namespace Poirot\ContentClient\Client\PlatformRest;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;


class ServerUrlEndpoints
{
    protected $serverBaseUrl;
    protected $command;


    /**
     * ServerUrlEndpoints constructor.
     *
     * @param $serverBaseUrl
     * @param $command
     */
    function __construct($serverBaseUrl, $command, $ssl = false)
    {
        $this->serverBaseUrl = (string)$serverBaseUrl;
        $this->command = $command;
    }

    function __toString()
    {
        return $this->_getServerHttpUrlFromCommand($this->command);
    }


    // ..

    /**
     * Determine Server Http Url Using Http or Https?
     *
     * @param iApiCommand $command
     *
     * @return string
     * @throws \Exception
     */
    protected function _getServerHttpUrlFromCommand($command)
    {
        $base = null;

        $cmMethod = strtolower((string)$command);
        switch ($cmMethod) {
            case 'create':
                $base = '/posts';
                break;
            case 'delete':
                $base = '/posts/' . $command->getContentId();
                break;
            case 'retrieve':
                $base = '/posts/' . $command->getContentId();
                break;
            case 'browse':
                $base = '/browse';
                break;
            case 'like':
                $base = '/posts/' . $command->getContentId() . '/likes';
                break;
            case 'unlike':
                $base = '/posts/' . $command->getContentId() . '/likes';
                break;
            case 'likerslist':
                $base = '/posts/' . $command->getContentId() . '/likes';
                break;
            case 'userlikes':
                $base = '/posts/liked';
                break;
            case 'sendcomment':
                $base = '/posts/' . $command->getContentId() . '/comments';
                break;
            case 'deletecomment':
                $base = '/posts/' . $command->getContentId() . '/comments/' . $command->getCommentId();
                break;
            case 'comments':
                $base = '/posts/' . $command->getContentId() . '/comments';
                break;
        }

        $serverUrl = rtrim($this->serverBaseUrl, '/');
        (!$base) ?: $serverUrl .= '/' . trim($base, '/');
        return $serverUrl;
    }
}
