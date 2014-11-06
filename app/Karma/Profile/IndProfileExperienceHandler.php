<?php
/**
 * User: kishan
 * Date: 11/6/14
 * Time: 11:42 AM
 */

namespace Karma\Profile;

use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;
use Karma\General\Experience;

class IndProfileExperienceHandler implements IndProfileInterface
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
                'title' => 'required|string',
                'workType' => 'required|enum=company,freelancer',
                'companyName' => 'optional|required=workType@company',
                'workCurrent' => 'required|string',
                'workStartMonth' => 'required|integer',
                'workStartYear' => 'required|integer',
                'workEndMonth' => 'optional|required=workCurrent@N',
                'workEndYear' => 'optional|required=workCurrent@N',
                'workId' => 'optional|integer'),
            11);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);

        if ($user) {
            $experience = Experience::selectExp($post->workId, $post->userId);

            if ($experience) {
                $experience->expTitle = ucwords($post->title);
                $experience->expType = $post->workType;
                $experience->expCompany = ucwords($post->companyName);
                $experience->expCurrent = $post->workCurrent;
                $experience->expStartDate = $post->workStartYear . '-' . $post->workStartMonth . '-01';
                $experience->expEndDate = $post->workCurrent == 'N' ? $post->workEndYear . '-' . $post->workEndMonth . '-01' : '0000-00-00';
            } else {
                $experience = Experience::createExp(
                    $post->userId,
                    ucwords($post->title),
                    $post->workType,
                    ucwords($post->companyName),
                    $post->workCurrent,
                    $post->workStartYear . '-' . $post->workStartMonth . '-01',
                    $post->workCurrent == 'N' ? $post->workEndYear . '-' . $post->workEndMonth . '-01' : '0000-00-00'
                );
            }
            $experience->save();

            // select
            $user = Experience::select(array(
                'expTitle',
                'expType',
                'expCompany',
                'expCurrent',
                'expStartDate',
                'expEndDate'
            ))
                ->where('expUserId', '=', $post->userId)
                ->get();

            // internal Log
            IndInternalLogHandler::addInternalLog($post->userId);

            // create cache for user
            $return = $this->indUserCacheHandler->make($user, 'experience', $post->userId);
            return $return;

        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }
} 