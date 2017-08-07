<?php

namespace Poirot\ContentClient;

use MongoDB\BSON\ObjectID;
use Poirot\ContentClient\Client\Command;
use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Poirot\ApiClient\aClient;
use Poirot\ApiClient\Interfaces\iPlatform;
use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ContentClient\Client\PlatformRest;
use Poirot\ContentClient\Entity\PostContentObject;
use Poirot\ContentClient\Exceptions\exTokenMismatch;
use Poirot\Std\Interfaces\Struct\iDataEntity;

/*

$c = new \Poirot\ContentClient\Client(
    'http://localhost:80/'
    , new \Poirot\ApiClient\TokenProviderSolid(
        new \Poirot\ApiClient\AccessTokenObject([
            'access_token' => '7f54e7d32ac517a0fdf3',
            'client_id'    => '#clientid',
            'expires_in'   => 3600,
            'scopes'       => 'scope otherscope'
        ])
    )
);

*/

class Client
    extends aClient
{
    protected $serverUrl;
    protected $platform;
    protected $tokenProvider;


    /**
     * Content Client constructor.
     *
     * @param string $serverUrl
     * @param iTokenProvider $tokenProvider
     */
    function __construct($serverUrl, iTokenProvider $tokenProvider)
    {
        $this->serverUrl = rtrim((string)$serverUrl, '/');
        $this->tokenProvider = $tokenProvider;
    }

    /**
     * Create a Post Content
     *
     * <php>
     * $r = $c->create(
     *   new \Poirot\ContentClient\Entity\PostContentObject([
     *     'content_type' => 'plain',
     *     'content'      => [
     *      'description' => 'This is content of plain content object.'
     *     ],
     *   ])
     * );
     * </php>
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

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Delete a Post Content
     *
     * @param ObjectID $id
     *
     * @return array
     */
    function delete(ObjectID $id)
    {
        $response = $this->call(
            new Command\Post\Delete($id)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Delete a Post Content
     *
     * @param ObjectID $id
     *
     * @return array
     */
    function retrieve(ObjectID $id)
    {
        $response = $this->call(
            new Command\Post\Retrieve($id)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Delete a Post Content
     *
     * @return array
     */
    function browse()
    {
        $response = $this->call(
            new Command\Post\Browse()
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * UnLike a Post
     *
     * @param ObjectID $id
     * @return array
     */
    function unlike(ObjectID $id)
    {
        $response = $this->call(
            new Command\Post\UnLike($id)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Like a Post
     *
     * @param ObjectID $id
     * @return array
     */
    function like(ObjectID $id)
    {
        $response = $this->call(
            new Command\Post\Like($id)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Get List of Likers of a Post
     *
     * @param ObjectID $id
     * @return array
     */
    function getLikersOfPost(ObjectID $id)
    {
        $response = $this->call(
            new Command\Post\LikersList($id)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Get List of  Likes of User
     *
     * @return array
     */
    function getLikesOfUser()
    {
        $response = $this->call(
            new Command\Post\UserLikes()
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Send Comment for a Post
     *
     * @param $content
     * @param ObjectID $contentId
     * @return array
     */
    function sendComment($content, ObjectID $contentId)
    {
        $response = $this->call(
            new Command\Comment\SendComment($content, $contentId)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Send Comment for a Post
     *
     * @param ObjectID $contentId
     * @param ObjectID $commentId
     * @return array
     */
    function deleteComment(ObjectID $contentId, ObjectID $commentId)
    {
        $response = $this->call(
            new Command\Comment\DeleteComment($contentId, $commentId)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
        return $r;
    }

    /**
     * Send Comment for a Post
     *
     * @param ObjectID $contentId
     * @return array
     */
    function comments(ObjectID $contentId)
    {
        $response = $this->call(
            new Command\Comment\Comments($contentId)
        );

        if ($ex = $response->hasException())
            throw $ex;

        $r = $response->expected();
        $r = ($r instanceof iDataEntity) ? $r->get('result') : $r;
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
        if (!$this->platform)
            $this->platform = new PlatformRest;


        # Default Options Overriding
        $this->platform->setServerUrl($this->serverUrl);

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

            if ($ex instanceof exTokenMismatch && $recall > 0) {
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
