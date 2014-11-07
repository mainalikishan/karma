<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 12:19 PM
 */

namespace Karma\Registration;


use Karma\Cache\CopUserCacheHandler;
use Karma\Cache\UserMasterCache;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Setting\CopDefaultSetting;
use Karma\Users\CopUser;
use Karma\General\Address;

class CopUserRegister
{

    /**
     * @var CopCustomRegister
     */
    private $copCustomRegister;
    /**
     * @var CopLinkedInRegister
     */
    private $copLinkedInRegister;
    /**
     * @var \Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Cache\UserMasterCache
     */
    private $userMasterCache;
    /**
     * @var \Karma\Setting\CopDefaultSetting
     */
    private $copDefaultSetting;

    public function __construct(CopCustomRegister $copCustomRegister,
                                CopLinkedInRegister $copLinkedInRegister,
                                CopUserCacheHandler $copUserCacheHandler,
                                CopUser $copUser,
                                CopDefaultSetting $copDefaultSetting,
                                UserMasterCache $userMasterCache)
    {
        $this->copCustomRegister = $copCustomRegister;
        $this->copLinkedInRegister = $copLinkedInRegister;
        $this->copUserCacheHandler = $copUserCacheHandler;
        $this->copUser = $copUser;
        $this->userMasterCache = $userMasterCache;
        $this->copDefaultSetting = $copDefaultSetting;
    }

    /**
     * @param $post
     * @return mixed
     * @throws \Exception
     */
    public function checkRegistration($post)
    {
        $oauthType = $post->userOauthType;
        if ($oauthType !== 'copCustomRegister'
            && $oauthType !== 'copLinkedInRegister'
        ) {
            throw new \Exception('Illegal oauth type');
        }

        $address = false;
        if (isset($post->userAddressCoordinate) && !empty($post->userAddressCoordinate)) {
            $address = \CustomHelper::getAddressFromApi($post->userAddressCoordinate);
            if ($address) {
                $address = Address::makeAddress($address, $address->countryISO);
            }
        }

        if ($this->copUser->checkEmail($post->userEmail) !== false) {
            return \Lang::get('errors.duplicate_email');
        }

        $user = $this->$oauthType->register($post, $address);
        if($oauthType=='copLinkedInRegister')
        {
            $user = $user['user'];
        }
        if ($user) {
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
                ->where('userId', '=', $user->userId)
                ->first();

            // add internal log
            CopInternalLogHandler::addInternalLog($user->userId, $post);

            // create cache for user
            $this->copUserCacheHandler->make($user, 'basic', $user->userId);

            if($oauthType=='copLinkedInRegister')
            {
                if ($user['action'] == 'register') {
                    $this->copDefaultSetting->init($user->userId);
                }
                return $this->userMasterCache->init($user->userId);
            }

            return \Lang::get('messages.registration_successful');
        }
    }

}