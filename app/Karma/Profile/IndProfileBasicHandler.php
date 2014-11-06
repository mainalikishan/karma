<?php
/**
 * User: kishan
 * Date: 11/6/14
 * Time: 11:32 AM
 */

namespace Karma\Profile;

use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;
use Karma\Users\IndUserRepository;
use Karma\General\Address;

class IndProfileBasicHandler implements IndProfileInterface
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
    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'genderId' => 'required',
                'countryISO' => 'optional',
                'addressCoordinate' => 'optional',
                'dynamicAddressCoordinate' => 'optional',
                'fname' => 'required',
                'lname' => 'required',
                'birthDay' => 'required|integer',
                'birthMonth' => 'required|integer',
                'birthYear' => 'required|integer'),
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
                'userDOB' => $post->birthYear.'-'.$post->birthMonth.'-'.$post->birthDay
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
} 