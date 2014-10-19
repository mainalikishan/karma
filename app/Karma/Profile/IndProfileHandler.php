<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 11:35 AM
 */

namespace Karma\Profile;


use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;
use Karma\Users\IndUserRepository;
use Karma\General\Address;
use Karma\General\DummySkill;
use Karma\General\DummyProfession;
use Karma\General\Experience;

class IndProfileHandler
{

    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;
    /**
     * @var \Karma\Users\IndUserRepository
     */
    private $indUserRepository;
    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;

    public function __construct(IndUser $indUser,
                                IndUserRepository $indUserRepository,
                                IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUser = $indUser;
        $this->indUserRepository = $indUserRepository;
        $this->indUserCacheHandler = $indUserCacheHandler;
    }


    /**
     * @param $post
     * @return mixed
     * @throws \Exception
     */
    public function basic($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'updateType' => 'required|string',
                'userId' => 'required|integer',
                'token' => 'required',
                'genderId' => 'required',
                'countryISO' => 'optional',
                'addressCoordinate' => 'optional',
                'dynamicAddressCoordinate' => 'optional',
                'fname' => 'required',
                'lname' => 'required',
                'dob'  => 'required'),
            10);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);

        if ($user) {
            $address = false;
            $post->addressCoordinate = !empty($post->addressCoordinate) ? $post->addressCoordinate : $post->dynamicAddressCoordinate;
            // get address from google api
            if (!empty($post->addressCoordinate)) {
                $address = \CustomHelper::getAddressFromApi($post->addressCoordinate);
                if ($address) {
                    $address = Address::makeAddress($address, $address->countryISO);
                }
            }

            // update basic info
            $user->update(array(
                'userGenderId' => $post->genderId,
                'userCountryISO' => !empty($post->addressCoordinate) ? $address->addressCountryISO : $post->countryISO,
                'userAddressId' => $address ? $address->addressId : 0,
                'userAddressCoordinate' => $post->addressCoordinate,
                'userDynamicAddressCoordinate' =>
                    !empty($post->dynamicAddressCoordinate) ?
                        $post->dynamicAddressCoordinate :
                        $user->userDynamicAddressCoordinate,
                'userFname' => $post->fname,
                'userLname' => $post->lname,
                'userDOB' => $post->dob
            ));

            // select basic info
            $user = $this->indUser
                ->select(array(
                    'userId',
                    'userGenderId',
                    'userCountryISO',
                    'userAddressId',
                    'userAddressCoordinate',
                    'userDynamicAddressCoordinate',
                    'userFname',
                    'userLname',
                    'userEmail',
                    'userDOB',
                    'userOauthId',
                    'userOauthType',
                    'userPic',
                    'userRegDate'))
                ->where('userId', '=', $user->userId)
                ->first();

            // internal Log
            IndInternalLogHandler::addInternalLog($user->userId);

            // create cache for user
            $return = $this->indUserCacheHandler->make($user, 'basic', $user->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }

    public function whatIDo($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'updateType' => 'required|string',
                'userId' => 'required|integer',
                'token' => 'required',
                'professionId' => 'required',
                'skills' => 'required|array',
                'summary' => 'required'),
            6);

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

            if (!empty($post->professionId) && !is_numeric($post->professionId)) {
                $profession = DummyProfession::registerProfession($post->professionId);
            } else {
                $profession = $post->professionId;
            }

            // update info.
            $user->update(array(
                'userProfessionId' => $profession,
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

    public function experience($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'updateType' => 'required|string',
                'userId' => 'required|integer',
                'token' => 'required',
                'title' => 'required|string',
                'workType' => 'required|enum=company,freelancer',
                'companyName' => 'optional',
                'workCurrent' => 'required|string',
                'workStartMonth' => 'required|integer',
                'workStartYear' => 'required|integer',
                'workEndMonth' => 'optional',
                'workEndYear' => 'optional',
                'workId' => 'optional'),
            12);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);

        if ($user) {
            $experience = Experience::selectExp($post->workId, $post->userId);

            if ($experience) {
                $experience->expTitle = ucwords($post->title);
                $experience->expType = $post->workType;
                $experience->expCompany = ucwords($post->companyName);
                $experience->expCurrent = $post->workCurrent;
                $experience->expStartDate = $post->workStartYear.'-'.$post->workStartMonth.'-01';
                $experience->expEndDate = $post->workCurrent=='N'? $post->workEndYear.'-'.$post->workEndMonth.'-01': null;
            } else {
                $experience = Experience::createExp(
                    $post->userId,
                    ucwords($post->title),
                    $post->workType,
                    ucwords($post->companyName),
                    $post->workCurrent,
                    $post->workStartYear.'-'.$post->workStartMonth.'-01',
                    $post->workCurrent=='N'? $post->workEndYear.'-'.$post->workEndMonth.'-01': null
                );
            }
            $experience->save();

            // select
            $user = Experience::select(array(
                    'expId',
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