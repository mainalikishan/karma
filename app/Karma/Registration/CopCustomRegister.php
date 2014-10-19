<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Registration;

use Karma\Users\CopUserRepository;
use Karma\Users\CopUser;

class CopCustomRegister implements CopUserRegisterInterface
{

    /**
     * @var \Karma\Users\CopUserRepository
     */
    private $copUserRepository;
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;

    public function __construct(CopUserRepository $copUserRepository, CopUser $copUser)
    {
        $this->copUserRepository = $copUserRepository;
        $this->copUser = $copUser;
    }

    public function register($post, $address=false)
    {
        // check post array  fields
        \CustomHelper::postCheck($post, array('userCompanyName',
                'userEmail',
                'userPassword',
                'userOauthType',
                'userOauthId',
                'userAddressCoordinate'),
            6);

        // get four digit verification code
        $userEmailVerificationCode = \CustomHelper::generateRandomDigitCode();

        $user = $this->copUser;

        $user->userCountryISO = $address? $address->addressCountryISO : 0;
        $user->userAddressId = $address? $address->addressId : 0;
        $user->userCompanyName = $post->userCompanyName;
        $user->userEmail = $post->userEmail;
        $user->userPassword = \Hash::make($post->userPassword);
        $user->userOauthType = $post->userOauthType;
        $user->userOauthId = $post->userOauthId;
        $user->userAddressCoordinate = $post->userAddressCoordinate;
        $user->userDynamicAddressCoordinate = $post->userAddressCoordinate;
        $user->userEmailVerificationCode = $userEmailVerificationCode;

        $this->copUserRepository->save($user);
        \Event::fire('copUser.register', $user);
        return $user;

    }
} 