<?php
/**
 * User: kishan
 * Date: 11/6/14
 * Time: 11:47 AM
 */

namespace Karma\Profile;

use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;
use Karma\General\DummyUniversity;
use Karma\General\DummyDegree;
use Karma\General\Education;

class IndProfileEducationHandler implements IndProfileInterface
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
     */
    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'university' => 'required',
                'degree' => 'required',
                'passedYear' => 'required|integer',
                'eduId' => 'optional|integer'),
            6);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);
        if ($user) {
            $education = Education::selectEdu($post->eduId, $post->userId);

            if ($education) {
                $education->eduUniversityId = (!empty($post->university) && !is_numeric($post->university)) ?
                    DummyUniversity::registerUniversity($post->university) :
                    ucwords($post->university);
                $education->eduDegreeId = (!empty($post->degree) && !is_numeric($post->degree)) ?
                    DummyDegree::registerDegree($post->degree) :
                    ucwords($post->degree);
                $education->eduPassedYear = $post->passedYear;
            } else {
                $education = Education::createEdu(
                    $post->userId,
                    (!empty($post->university) && !is_numeric($post->university)) ?
                        DummyUniversity::registerUniversity($post->university) :
                        ucwords($post->university),
                    (!empty($post->degree) && !is_numeric($post->degree)) ?
                        DummyDegree::registerDegree($post->degree) :
                        ucwords($post->degree),
                    $post->passedYear
                );
            }
            $education->save();

            // select
            $user = Education::select(array(
                'eduUniversityId',
                'eduDegreeId',
                'eduPassedYear'
            ))
                ->where('eduUserId', '=', $post->userId)
                ->get();

            // internal Log
            IndInternalLogHandler::addInternalLog($post->userId);

            // create cache for user
            $return = $this->indUserCacheHandler->make($user, 'education', $post->userId);
            return $return;
        }
    }

} 