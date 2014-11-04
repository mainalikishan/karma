<?php
/**
 * User: kishan
 * Date: 10/29/14
 * Time: 9:33 PM
 */

namespace Karma\Setting;

use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;

class IndPreferenceHandler
{

    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;

    public function __construct(IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUserCacheHandler = $indUserCacheHandler;
    }

    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'workAs' => 'required|enum=Contractor,Freelancer,Consultant',
                'currencyCode' => 'required',
                'minSalary' => 'required|integer',
                'salaryRule' => 'required|enum=Yearly,Monthly,Hourly',
                'langCode'=> 'required|string'),
            7);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);
        if ($user) {
            $preferenceData = json_encode(array(
                'workAs' => $post->workAs,
                'currencyCode' => $post->currencyCode,
                'minSalary' => $post->minSalary,
                'salaryRule' => $post->salaryRule,
                'langCode' => $post->langCode
            ));
            $preference = IndPreference::selectPreferenceByUserId($post->userId);
            if ($preference) {
                $preference->preferenceData = $preferenceData;
            }
            else {
                $preference = IndPreference::createPreference($post->userId, $preferenceData);
            }
            $preference->save();

            // lets re-select after insert or update
            $preference = IndPreference::selectPreferenceByUserId($post->userId);

            // internal Log
            IndInternalLogHandler::addInternalLog($post->userId, $post);

            // create or update cache for user
            $return = $this->indUserCacheHandler->make($preference, 'preference', $post->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }

} 