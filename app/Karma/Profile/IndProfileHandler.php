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
                'updateType',
                'userId',
                'token',
                'genderId',
                'countryISO',
                'addressCoordinate',
                'dynamicAddressCoordinate',
                'fname',
                'lname',
                'email',
                'dob'),
            11);

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
                'userEmail' => $post->email,
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
                'updateType',
                'userId',
                'token',
                'professionId',
                'skills',
                'summary'),
            6);

        // skills must be in array
        if (!is_array($post->skills)) {
            throw new \Exception(\Lang::get('errors.invalid_post_request'));
        }

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);

        if ($user) {
            foreach ($post->skills as $skill) {
                if (!is_numeric($skill)) {
                    DummySkill::registerSkill($skill);
                }
            }
            $skillIds = implode(',', $post->skills);
            $user->create(array(
                'userProfessionId' => $post->professionId,
                'userSkillIds' => $skillIds
            ));

            // select profession id
            $user = $this->indUser
                ->select(array(
                    'userProfessionId',
                    'userSkillIds'
                ))
                ->where('userId', '=', $user->userId)
                ->first();

            // internal Log
            IndInternalLogHandler::addInternalLog($user->userId);

            // create cache for user
            $return = $this->indUserCacheHandler->make($user, 'whatIDo', $user->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));

    }
}