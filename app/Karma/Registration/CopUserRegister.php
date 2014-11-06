<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 12:19 PM
 */

namespace Karma\Registration;


use Karma\Cache\CopUserCacheHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
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
     * @param CopCustomRegister $copCustomRegister
     * @param CopLinkedInRegister $copLinkedInRegister
     * @param CopUserCacheHandler $copUserCacheHandler
     * @param CopUser $copUser
     */
    public function __construct(CopCustomRegister $copCustomRegister,
                                CopLinkedInRegister $copLinkedInRegister,
                                CopUserCacheHandler $copUserCacheHandler,
                                CopUser $copUser)
    {
        $this->copCustomRegister = $copCustomRegister;
        $this->copLinkedInRegister = $copLinkedInRegister;
        $this->copUserCacheHandler = $copUserCacheHandler;
        $this->copUser = $copUser;
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

        if($this->copUser->checkEmail($post->userEmail)!==false)
        {
            return \Lang::get('errors.duplicate_email');
        }

        $user = $this->$oauthType->register($post, $address);

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
            CopInternalLogHandler::addInternalLog($user->userId,$post);

            // create cache for user
            $this->copUserCacheHandler->make($user, 'basic', $user->userId);
            return \Lang::get('messages.registration_successful');
        }
    }

}