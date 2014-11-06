<?php
/**
 * User: kishan
 * Date: 11/4/14
 * Time: 10:57 PM
 */

namespace Karma\Setting;


use Karma\Users\CopUser;
use Karma\Log\CopChangeLog\CopChangeLogHandler;
use Karma\Users\CopUserRepository;

class CopAccountSettingHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Users\CopUserRepository
     */
    private $copUserRepository;
    /**
     * @var \Karma\Log\CopChangeLog\CopChangeLogHandler
     */
    private $copChangeLogHandler;


    /**
     * @param CopUser $copUser
     * @param CopUserRepository $copUserRepository
     * @param CopChangeLogHandler $copChangeLogHandler
     */
    public function __construct(
        CopUser $copUser,
        CopUserRepository $copUserRepository,
        CopChangeLogHandler $copChangeLogHandler)
    {
        $this->copUser = $copUser;
        $this->copUserRepository = $copUserRepository;
        $this->copChangeLogHandler = $copChangeLogHandler;
    }


    /**
     * @param $post
     * @return bool
     * @throws \Exception
     */
    public function updateAccountStatus($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'status' => 'required|enum=tempDeactivate|perDeactivate'),
            3);

        $user = CopUser::loginCheck($post->token, $post->userId);
        if($user) {
            $user->userAccountStatus = $post->status;
            $user->save();
            return true;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function changePassword($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array(
                'userId' => 'required|integer',
                'userToken' => 'required',
                'userPassword' => 'required',
                'newPassword' => 'required',
                'confirmPassword' => 'required'),
            5);

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

                    $this->copChangeLogHandler->addChangeLog($userId, 'PASSWORD', $user->userPassword);
                    return \Lang::get('messages.password_change_successful');
                }
                throw new \Exception(\Lang::get('errors.confirm_password_mismatched'));
            }
            throw new \Exception(\Lang::get('errors.invalid_current_password'));
        }
        throw new \Exception('errors.something_went_wrong');
    }
} 