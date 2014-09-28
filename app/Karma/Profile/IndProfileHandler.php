<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 11:35 AM
 */

namespace Karma\Profile;


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

    public function __construct(IndUser $indUser, IndUserRepository $indUserRepository)
    {
        $this->indUser = $indUser;
        $this->indUserRepository = $indUserRepository;
    }


    /**
     * @param $post
     * @return mixed
     */
    public function basic($post)
    {
        \IndUserLoginCheck::loginCheck($post->token, $post->id);

        if ($user) {
            $user->userLastLogin = date('Y-m-d H:i:s');
            $user->userLoginCount = $user->userLoginCount + 1;
            $user->userLastLoginIp = \Request::getClientIp(true);
        }
        $this->indUserRepository->save($user);
        $user = $this->indUser
            ->select(array(
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
        return $user;
    }
}