<?php
/**
 * User: Prakash
 * Date: 9/26/14
 * Time: 1:43 PM
 */

namespace Karma\Profile;

use Karma\Cache\CopUserCacheHandler;
use Karma\Log\CopChangeLog\CopChangeLogHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Users\CopUser;
use Karma\General\Address;

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
    /**
     * @var \Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;

    public function __construct(CopUser $copUser,
                                CopChangeLogHandler $copChangeLogHandler,
                                CopUserCacheHandler $copUserCacheHandler)
    {
        $this->copUser = $copUser;
        $this->copChangeLogHandler = $copChangeLogHandler;
        $this->copUserCacheHandler = $copUserCacheHandler;
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
            array('userId'=>'required',
                'userToken'=>'required',
                'userCompanyName'=> 'required|string',
                'userIndustryTypeId'=>'required|integer',
                'userAddressCoordinate'=>'required',
                'userCompanyPhone'=>'optional',
                'userSummary'=>'optional'),
            7);

        //getting post value
        $userId = $data->userId;
        $userToken = $data->userToken;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        //select and return cop user data if token id and user id is valid
        $users = $this->copUser->getUserById($userId);
        // return $users;


        // add company filed value change log to change log table
        foreach ($this->updateKeys() as $key => $value) {

            if (!empty($users->$value) && isset($data->$value) && $users->$value != $data->$value) {
                $this->copChangeLogHandler->addChangeLog($userId, $key, $users->$value);
            }
        }

        // update copUser table if token id and user id is valid

        $address = false;
        if (isset($data->userAddressCoordinate) && !empty($data->userAddressCoordinate)) {
            $address = \CustomHelper::getAddressFromApi($data->userAddressCoordinate);
            if ($address) {
                $address = Address::makeAddress($address, $address->countryISO);
            }
        }

        $users->userCountryISO = $address ? $address->addressCountryISO : 0;
        $users->userAddressId = $address ? $address->addressId : 0;
        $users->userCompanyName = $data->userCompanyName;
        $users->userIndustryTypeId = $data->userIndustryTypeId;
        $users->userAddressCoordinate = $data->userAddressCoordinate;
        $users->userDynamicAddressCoordinate = $data->userAddressCoordinate;
        $users->userCompanyPhone = $data->userCompanyPhone;
        $users->userSummary = $data->userSummary;
        $users->userId = $userId;

        $users->save();


        // select only what is needed
        $user = $this->copUser
            ->select(array(
                'userId',
                'userIndustryTypeId',
                'userCountryISO',
                'userAddressId',
                'userAddressCoordinate',
                'userDynamicAddressCoordinate',
                'userCompanyPhone',
                'userCompanyName',
                'userEmail',
                'userCoverPic',
                'userProfilePic',
                'userSummary',
                'userRegDate',
                'userUpdatedDate',
                'userOauthId',
                'userOauthType',
                'userToken'
            ))
            ->where('userId', '=', $userId)
            ->first();

        // add internal log
        CopInternalLogHandler::addInternalLog($userId);

        // create cache for user
        $this->copUserCacheHandler->make($user, 'basic', $userId);

        return \Lang::get('messages.updated_successfully');
    }
} 