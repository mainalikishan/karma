<?php
/**
 * User: kishan
 * Date: 9/20/14
 * Time: 1:45 PM
 */

namespace Karma\Registration;


use Karma\Users\IndUserRepository;
use Karma\Users\IndUser;

class IndTwitterRegister implements IndUserRegisterInterface
{
    const oauthType = 'Twitter';
    /**
     * @var \Karma\Users\IndUserRepository
     */
    private $indUserRepository;
    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;

    public function __construct(IndUserRepository $indUserRepository, IndUser $indUser)
    {
        $this->indUserRepository = $indUserRepository;
        $this->indUser = $indUser;
    }

    public function register($post)
    {
        $user = $this->indUser->isRegisted($post->oauthId, self::oauthType);

        if ($user) {
            $user->userLastLogin = date('Y-m-d H:i:s');
            $user->userLoginCount = $user->userLoginCount + 1;
            $user->userLastLoginIp = \Request::getClientIp(true);
        } else {
            $user = $this->indUser->register(
                $post->genderId,
                $post->countryId,
                $post->addressId,
                $post->jobTitleId,
                $post->fname,
                $post->lname,
                $post->email,
                \Hash::make($post->password),
                \CustomHelper::generateToken($post->email),
                $post->dob,
                $post->oauthId,
                self::oauthType,
                $post->summary,
                'profile_pic',
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
                '1',
                \Request::getClientIp(true),
                'Active',
                'active'
            );
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