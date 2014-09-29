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
            array('updateType', 'id', 'token', 'genderId', 'countryId', 'addressId', 'fname', 'lname', 'email', 'dob'),
            10);

        $user = $this->indUser->loginCheck($post->token, $post->id);

        if($user) {
            $user->userGenderId = $post->genderId;
            $user->userCountryId = $post->countryId;
            $user->userAddressId = $post->addressId;
            $user->userFname = $post->fname;
            $user->userLname = $post->lname;
            $user->userEmail = $post->email;
            $user->userDOB = $post->dob;

            $this->indUserRepository->save($user);
            $user = $this->indUser
                ->select(array(
                    'userId',
                    'userGenderId',
                    'userCountryId',
                    'userAddressId',
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