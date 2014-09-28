<?php
/**
 * User: Prakash
 * Date: 9/26/14
 * Time: 1:43 PM
 */

namespace Karma\Profile;

use Karma\Users\CopUser;
use Karma\Users\CopUserRepository;

class CopChangePasswordHandler
{

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Users\CopUserRepository
     */
    private $copUserRepository;

    public function __construct(CopUser $copUser, CopUserRepository $copUserRepository)
    {
        $this->copUser = $copUser;
        $this->copUserRepository = $copUserRepository;
    }

    public function changePassword($data)
    {
        //getting post value
        $userId = $data->userId;
        $userToken = $data->userToken;
        $userPassword = $data->userPassword;
        $newPassword = $data->newPassword;
        $confirmPassword = $data->confirmPassword;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        $user = $this->copUser->fetchPassword($data->userId);
        if ($user) {
            //check current password
            if (\Hash::check($userPassword, $user->userPassword)) {
                // check old database password and new password
                if (\Hash::check($newPassword, $user->userPassword)) {
                    throw new \Exception(\Lang::get('errors.new_password_not_same_to_old'));
                } else if ($newPassword === $confirmPassword) {
                    // update password
                    $user->userPassword = \Hash::make($newPassword);
                    $this->copUserRepository->save($user);
                    return Lang::get('messages.password_change_successful');
                }
                throw new \Exception(\Lang::get('errors.confirm_password_mismatched'));
            }
            throw new \Exception(\Lang::get('errors.invalid_current_password'));
        }
        throw new \Exception('errors.something_went_wrong');
    }
} 