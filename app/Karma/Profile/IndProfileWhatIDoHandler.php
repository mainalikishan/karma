<?php
/**
 * User: kishan
 * Date: 11/6/14
 * Time: 11:36 AM
 */

namespace Karma\Profile;

use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;
use Karma\General\DummySkill;
use Karma\General\DummyProfession;

class IndProfileWhatIDoHandler implements IndProfileInterface
{
    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;
    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;


    /**
     * @param IndUser $indUser
     * @param IndUserCacheHandler $indUserCacheHandler
     */
    public function __construct(IndUser $indUser,
                                IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUser = $indUser;
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
                'professionId' => 'required',
                'skills' => 'required|array',
                'summary' => 'required'),
            5);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);

        if ($user) {
            $userSkills = [];
            foreach ($post->skills as $skill) {
                if (!empty($skill)) {
                    if (!is_numeric($skill)) {
                        $userSkills[] = DummySkill::registerSkill($skill);
                    } else {
                        $userSkills[] = ucwords($skill);
                    }
                }
            }
            $skillIds = implode(',', $userSkills);

            // update info.
            $user->update(array(
                'userProfessionId' =>
                    (!empty($post->professionId) && !is_numeric($post->professionId))?
                        DummyProfession::registerProfession($post->professionId):
                        ucwords($post->professionId),
                'userSkillIds' => $skillIds,
                'userSummary' => $post->summary
            ));

            // select
            $user = $this->indUser
                ->select(array(
                    'userProfessionId',
                    'userSkillIds',
                    'userSummary'
                ))
                ->where('userId', '=', $post->userId)
                ->first();

            // internal Log
            IndInternalLogHandler::addInternalLog($post->userId);

            // create cache for user
            $return = $this->indUserCacheHandler->make($user, 'whatIDo', $post->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));

    }
} 