<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 5:19 PM
 */

namespace Karma\Setting;


use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;

class IndPrivacyHandler
{

    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;


    /**
     * @param IndUserCacheHandler $indUserCacheHandler
     */
    public function __construct(IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUserCacheHandler = $indUserCacheHandler;
    }


    /**
     * @param $post
     * @return mixed
     * @throws \Exception
     */
    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'inSearch' => 'required|enum=true,false',
                'showEmail' => 'required|enum=true,false',
                'showDOB' => 'required|enum=true,false'),
            5);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);
        if ($user) {
            $privacyData = json_encode(array(
                'inSearch' => $post->inSearch,
                'showEmail' => $post->showEmail,
                'showDOB' => $post->showDOB
            ));
            $privacy = IndPrivacy::selectPrivacyByUserId($post->userId);
            if($privacy) {
                $privacy->privacyData = $privacyData;
            } else {
                $privacy = IndPrivacy::createPrivacy($post->userId, $privacyData);
            }
            $privacy->save();

            // lets re-select after insert or update
            $privacy = IndPrivacy::selectPrivacyByUserId($post->userId);

            // internal Log
            IndInternalLogHandler::addInternalLog($post->userId, $post);

            // create or update cache for user
            $return = $this->indUserCacheHandler->make($privacy, 'privacy', $post->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }
}