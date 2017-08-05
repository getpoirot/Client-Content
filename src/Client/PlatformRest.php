<?php

namespace Poirot\ContentClient\Client;

use Poirot\ContentClient\Client\Command;
use Poirot\ApiClient\aPlatform;
use Poirot\ApiClient\Exceptions\exConnection;
use Poirot\ApiClient\Exceptions\exHttpResponse;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ContentClient\Client\PlatformRest\ServerUrlEndpoints;


class PlatformRest
    extends aPlatform
    implements iPlatform
{
    /** @var iApiCommand */
    protected $Command;

    // Options:
    protected $usingSsl = false;
    protected $serverUrl = null;


    // Alters

    /**
     * @param Command\Post\Create $command
     * @return Response
     */
    protected function _Create(Command\Post\Create $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $args = iterator_to_array($command);

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('POST', $url, $args, $headers);
        return $response;
    }

    /**
     * @param Command\Post\Delete $command
     * @return Response
     */
    protected function _Delete(Command\Post\Delete $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('DELETE', $url, [], $headers);
        return $response;
    }

    /**
     * @param Command\Post\Retrieve $command
     * @return Response
     */
    protected function _Retrieve(Command\Post\Retrieve $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('GET', $url, [], $headers);
        return $response;
    }

    /**
     * @param Command\Post\Browse $command
     * @return Response
     */
    protected function _Browse(Command\Post\Browse $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('GET', $url, [], $headers);
        return $response;
    }

    /**
     * @param Command\Post\Like $command
     * @return Response
     */
    protected function _Like(Command\Post\Like $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('POST', $url, [], $headers);
        return $response;
    }

    /**
     * @param Command\Post\UnLike $command
     * @return Response
     */
    protected function _UnLike(Command\Post\UnLike $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('DELETE', $url, [], $headers);
        return $response;
    }


    /**
     * @param Command\Post\LikersList $command
     * @return Response
     */
    protected function _LikersList(Command\Post\LikersList $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('GET', $url, [], $headers);
        return $response;
    }

    /**
     * @param Command\Post\UserLikes $command
     * @return Response
     */
    protected function _UserLikes(Command\Post\UserLikes $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());

        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('GET', $url, [], $headers);
        return $response;
    }

    /**
     * @param Command\Comment\SendComment $command
     * @return Response
     */
    protected function _SendComment(Command\Comment\SendComment $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());
        $args = [
            'comment' => $command->getContent()
        ];
        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('POST', $url, $args, $headers);
        return $response;
    }


    /**
     * @param Command\Comment\DeleteComment $command
     * @return Response
     */
    protected function _DeleteComment(Command\Comment\DeleteComment $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());
        $args = [];
        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('DELETE', $url, $args, $headers);
        return $response;
    }

    /**
     * @param Command\Comment\Comments $command
     * @return Response
     */
    protected function _Comments(Command\Comment\Comments $command)
    {
        $headers = [];

        // Request With Client Credential
        // As Authorization Header
        $headers['Authorization'] = 'Bearer ' . ($command->getToken()->getAccessToken());
        $args = [];
        $url = $this->_getServerUrlEndpoints($command);
        $response = $this->_sendViaCurl('GET', $url, $args, $headers);
        return $response;
    }

    // Options

    /**
     * Set Server Url
     *
     * @param string $url
     *
     * @return $this
     */
    function setServerUrl($url)
    {
        $this->serverUrl = (string)$url;
        return $this;
    }

    /**
     * Server Url
     *
     * @return string
     */
    function getServerUrl()
    {
        return $this->serverUrl;
    }

    /**
     * Using SSl While Send Request To Server
     *
     * @param bool $flag
     *
     * @return $this
     */
    function setUsingSsl($flag = true)
    {
        $this->usingSsl = (bool)$flag;
        return $this;
    }

    /**
     * Ssl Enabled?
     *
     * @return bool
     */
    function isUsingSsl()
    {
        return $this->usingSsl;
    }


    // ..

    protected function _sendViaCurl($method, $url, array $data, array $headers = [])
    {
        if (!extension_loaded('curl'))
            throw new \Exception('cURL library is not loaded');


        $handle = curl_init();

        $h = [];
        foreach ($headers as $key => $val)
            $h[] = $key . ': ' . $val;
        $headers = $h;


        $defHeaders = [
            'Accept: application/json',
            'charset: utf-8'
        ];

        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'POST' || $method == 'PUT') {
            /*$defHeaders += [
                'Content-Type: application/x-www-form-urlencoded'
            ];*/

            curl_setopt($handle, CURLOPT_POST, true);

            # build request body
            $_f_build = function($data) use (&$_f_build) {
                $args     = func_get_args();
                $isNested = @$args[1];

                foreach ($data as $k => $d) {
                    // Build PHP Array Request Params Compatible With Curl
                    // meta => ['name' => (string)] ---> meta['name'] = (string)
                    if (is_array($d)) {
                        foreach ($d as $i => $v) {
                            if (is_array($v)) {
                                // Nested Array
                                foreach ($d = $_f_build($v, true) as $kn => $kv)
                                    $data[$k . '[' . $i . ']' . $kn] = $kv;

                            } else {
                                if ($isNested)
                                    $data['[' . $k . ']' . '[' . $i . ']'] = $v;
                                else
                                    $data[$k . '[' . $i . ']'] = $v;
                            }
                        }

                        unset($data[$k]);
                    }
                }

                return $data;
            };

            $data = $_f_build($data);

            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

        } else {
            $urlEncodeData = http_build_query($data);
            // TODO set data in qcuery params
        }

        $headers = array_merge(
            $defHeaders
            , $headers
        );


        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);


        # Send Post Request
        $cResponse = curl_exec($handle);
        $cResponseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $cContentType = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);

        if ($curl_errno = curl_errno($handle)) {
            // Connection Error
            $curl_error = curl_error($handle);
            throw new exConnection($curl_error, $curl_errno);
        }

        $exception = null;
        if (!($cResponseCode >= 200 && $cResponseCode < 300)) {
            $message = $cResponse;
            if ($cResponseCode >= 300 && $cResponseCode < 400)
                $message = 'Response Redirected To Another Uri.';

            $exception = new exHttpResponse($message, $cResponseCode);
        }

        $response = new Response(
            $cResponse
            , $cResponseCode
            , ['content_type' => $cContentType]
            , $exception
        );

        return $response;
    }

    protected function _getServerUrlEndpoints($command)
    {
        $url = new ServerUrlEndpoints(
            $this->getServerUrl()
            , $command
            , $this->isUsingSsl()
        );

        return (string)$url;
    }
}
