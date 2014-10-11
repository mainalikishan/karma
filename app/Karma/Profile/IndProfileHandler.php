<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 11:35 AM
 */

namespace Karma\Profile;


use Karma\Cache\IndUserCacheHandler;
use Karma\Users\IndUser;
use Karma\Users\IndUserRepository;
use Karma\General\Address;
use Karma\General\Country;

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

    public function __construct(IndUser $indUser, IndUserRepository $indUserRepository, IndUserCacheHandler $indUserCacheHandler)
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
        \CustomHelper::postCheck($post,
            array('updateType', 'userId', 'token', 'genderId', 'countryISO', 'addressCoordinate', 'fname', 'lname', 'email', 'dob'),
            10);

        $user = $this->indUser->loginCheck($post->token, $post->userId);

        if($user) {

            $address = \CustomHelper::getAddressFromApi($post->addressCoordinate);
            if($address) {
                $country = Country::selectCountryNameByISO($address->countryISO);
                $country = $country? $country->countryISOCode: 0;
                $address = Address::makeAddress($address, $country);
            }

            $user->userGenderId = $post->genderId;
            $user->userCountryISO = $post->countryISO;
            $user->userAddressId = $address? $address->addressId: 0;
            $user->userAddressCoordinate = $post->addressCoordinate;
            $user->userFname = $post->fname;
            $user->userLname = $post->lname;
            $user->userEmail = $post->email;
            $user->userDOB = $post->dob;

            $this->indUserRepository->save($user);
            $user = $this->indUser
                ->select(array(
                    'userId',
                    'userGenderId',
                    'userCountryISO',
                    'userAddressId',
                    'userAddressCoordinate',
                    'userDynamicAddressCoordinate',
                    'userJobTitleId',
                    'userFname',
                    'userLname',
                    'userEmail',
                    'userDOB',
                    'userOauthId',
                    'userOauthType',
                    'userSummary',
                    'userPic',
                    'userRegDate'))
                ->where('userId', '=', $user->userId)
                ->first();

            // create cache for user
            $return = $this->indUserCacheHandler->make($user, 'basic', $user->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }
}