<?php
/**
 * User: kishan
 * Date: 9/20/14
 * Time: 1:33 PM
 */

namespace Karma\Registration;


use Carbon\Carbon;
use Karma\Users\IndUser;

class IndLinkedinRegister implements IndUserRegisterInterface
{
    const oauthType = 'Linkedin';
    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;


    /**
     * @param IndUser $indUser
     */
    public function __construct(IndUser $indUser)
    {
        $this->indUser = $indUser;
    }


    /**
     * @param $post
     * @param $address
     * @return bool|static
     */
    public function register($post, $address = false)
    {
        $user = $this->indUser->isRegisted($post->oauthId, self::oauthType);

        if ($user) {
            $action = 'login';
            $user->userLastLogin = date('Y-m-d H:i:s');
            $user->userLoginCount = $user->userLoginCount + 1;
            $user->userLastLoginIp = \Request::getClientIp(true);
            $user->userDynamicAddressCoordinate = $post->addressCoordinate;
        } else {
            $action = 'register';
            $user = $this->indUser->register(
                $post->genderId,
                $address ? $address->addressCountryISO : 0,
                $address ? $address->addressId : 0,
                $post->addressCoordinate,
                $post->addressCoordinate, // dynamic coordinate
                0, // profession will be none at the time of registration
                '', // skills will be none at the time of registration
                $post->fname,
                $post->lname,
                $post->email,
                \Hash::make(\CustomHelper::generateRandomCharacters()),
                \CustomHelper::generateToken($post->email),
                $post->dob,
                $post->oauthId,
                self::oauthType,
                $post->summary,
                'profile_pic',
                Carbon::now(),
                Carbon::now(),
                '1',
                \Request::getClientIp(true),
                'Active',
                'active'
            );
        }

        $user->save();

        return array('action' => $action, 'user' => $user);
    }
}