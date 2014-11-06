<?php
/**
 * User: kishan
 * Date: 11/3/14
 * Time: 10:31 PM
 */

namespace Karma\Setting;


use Karma\Cache\CopUserCacheHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;

class CopPreferenceHandler
{

    /**
     * @var \Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;


    /**
     * @param CopUserCacheHandler $copUserCacheHandler
     */
    public function __construct(CopUserCacheHandler $copUserCacheHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
    }


    /**
     * @param $post
     * @return mixed
     */
    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'currencyCode' => 'required|string',
                'langCode'=> 'required|string'),
            4);


        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($post->token, $post->userId);

        $preferenceData = json_encode(array(
            'currencyCode' => $post->currencyCode,
            'langCode' => $post->langCode
        ));
        $preference = CopPreference::selectPreferenceByUserId($post->userId);
        if ($preference) {
            $preference->preferenceData = $preferenceData;
        } else {
            $preference = CopPreference::createPreference($post->userId, $preferenceData);
        }
        $preference->save();

        // lets re-select after insert or update
        $preference = CopPreference::selectPreferenceByUserId($post->userId);

        // internal Log
        CopInternalLogHandler::addInternalLog($post->userId, $post);

        // create or update cache for user
        $return = $this->copUserCacheHandler->make($preference, 'preference', $post->userId);
        return $return;
    }
}