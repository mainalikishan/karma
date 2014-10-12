<?php
/**
 * User: Prakash
 * Date: 9/26/14
 * Time: 1:43 PM
 */

namespace Karma\Profile;

use Karma\Log\CopChangeLog\CopChangeLogHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Users\CopUser;

class CopProfileHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Log\CopChangeLog\CopChangeLogHandler
     */
    private $copChangeLogHandler;

    public function __construct(CopUser $copUser, CopChangeLogHandler $copChangeLogHandler)
    {
        $this->copUser = $copUser;
        $this->copChangeLogHandler = $copChangeLogHandler;
    }

    private function updateKeys()
    {
        return array(
            'CNAME' => 'userCompanyName',
            'COUNTRY' => 'userCountryISO',
            'ADDRESS' => 'userAddressId',
            'PHONE' => 'userCompanyPhone',
            'INDUSTRY_TYPE' => 'userIndustryTypeId',
            'SUMMARY' => 'userSummary');
    }

    public function updateProfile($data)
    {

        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userId', 'userToken', 'userIndustryTypeId', 'userCountryISO', 'userAddressId', 'userCompanyPhone', 'userCompanyName', 'userSummary'),
            8);
        //getting post value
        $userId = $data->userId;
        $userToken = $data->userToken;
        $userIndustryTypeId = $data->userIndustryTypeId;
        $userCountryISO = $data->userCountryISO;
        $userAddressId = $data->userAddressId;
        $userCompanyPhone = $data->userCompanyPhone;
        $userCompanyName = $data->userCompanyName;
        $userSummary = $data->userSummary;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        //select and return cop user data if token id and user id is valid
        $users = CopUser::getUserById($userId);

        // update copUser table if token id and user id is valid
        CopUser::updateUserProfileInfo($userId,
            $userToken,
            $userIndustryTypeId,
            $userCountryISO,
            $userAddressId,
            $userCompanyPhone,
            $userCompanyName,
            $userSummary);

        // add company filed value change log to change log table
        foreach ($this->updateKeys() as $key => $value) {
            if (!empty($users->$value) && $users->$value != $$value) {
                $this->copChangeLogHandler->addChangeLog($userId, $key, $users->$value);
            }
        }
        // add internal log
        CopInternalLogHandler:: addInternalLog($userId);
        return \Lang::get('messages.updated_successfully');
    }
} 