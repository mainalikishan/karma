<?php
/**
 * User: Prakash
 * Date: 9/26/14
 * Time: 1:43 PM
 */

namespace Karma\Profile;

use Karma\Users\CopUser;

class CopProfileHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;

    public function __construct(CopUser $copUser)
    {
        $this->copUser = $copUser;
    }

    public function updateProfile($data)
    {

        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userId', 'userToken', 'userIndustryTypeId', 'userCountryId', 'userAddressId', 'userCompanyPhone', 'userCompanyName', 'userSummary'),
            8);
        //getting post value
        $userId = $data->userId;
        $userToken = $data->userToken;
        $userIndustryTypeId = $data->userIndustryTypeId;
        $userCountryId = $data->userCountryId;
        $userAddressId = $data->userAddressId;
        $userCompanyPhone = $data->userCompanyPhone;
        $userCompanyName = $data->userCompanyName;
        $userSummary = $data->userSummary;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // update copUser table if token id and user id is valid
        CopUser::updateUserProfileInfo($userId,
            $userToken,
            $userIndustryTypeId,
            $userCountryId,
            $userAddressId,
            $userCompanyPhone,
            $userCompanyName,
            $userSummary);

        //select and return cop user data if update is successful
        return CopUser::getUserById($userId);
    }
} 