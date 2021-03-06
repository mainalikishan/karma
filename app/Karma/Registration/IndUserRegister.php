<?php
/**
 * User: Kishan
 * Date: 9/20/14
 * Time: 12:19 PM
 */
namespace Karma\Registration;

use Karma\Cache\IndUserCacheHandler;
use Karma\Cache\UserMasterCache;
use Karma\General\Address;
use Karma\Setting\IndDefaultSetting;
use Karma\Setting\IndPreference;
use Karma\Users\IndUser;


/**
 * Class IndUserRegister
 * @package Karma\Registration
 */
class IndUserRegister
{
    /**
     * @var IndFacebookRegister
     */
    private $indFacebookRegister;
    /**
     * @var IndTwitterRegister
     */
    private $indTwitterRegister;
    /**
     * @var IndLinkedinRegister
     */
    private $indLinkedinRegister;
    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;
    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;
    /**
     * @var \Karma\Setting\IndDefaultSetting
     */
    private $indDefaultSetting;
    /**
     * @var \Karma\Cache\UserMasterCache
     */
    private $userMasterCache;


    /**
     * @param IndFacebookRegister $indFacebookRegister
     * @param IndTwitterRegister $indTwitterRegister
     * @param IndLinkedinRegister $indLinkedinRegister
     * @param IndUser $indUser
     * @param IndUserCacheHandler $indUserCacheHandler
     * @param IndDefaultSetting $indDefaultSetting
     * @param UserMasterCache $userMasterCache
     */
    public function __construct(IndFacebookRegister $indFacebookRegister,
                                IndTwitterRegister $indTwitterRegister,
                                IndLinkedinRegister $indLinkedinRegister,
                                IndUser $indUser,
                                IndUserCacheHandler $indUserCacheHandler,
                                IndDefaultSetting $indDefaultSetting,
                                UserMasterCache $userMasterCache)
    {

        $this->indFacebookRegister = $indFacebookRegister;
        $this->indTwitterRegister = $indTwitterRegister;
        $this->indLinkedinRegister = $indLinkedinRegister;
        $this->indUser = $indUser;
        $this->indUserCacheHandler = $indUserCacheHandler;
        $this->indDefaultSetting = $indDefaultSetting;
        $this->userMasterCache = $userMasterCache;
    }


    /**
     * @param $post
     * @return bool
     * @throws \Exception
     */
    public function checkRegistration($post)
    {
        $oauthType = $post->oauthType;
        if ($oauthType !== 'indFacebookRegister'
            && $oauthType !== 'indTwitterRegister'
            && $oauthType !== 'indLinkedinRegister'
        ) {
            throw new \Exception('Illegal oauth type');
        }

        $address = false;
        if (isset($post->addressCoordinate)) {
            $address = \CustomHelper::getAddressFromApi($post->addressCoordinate);
            if ($address) {
                $address = Address::makeAddress($address, $address->countryISO);
            }
        }

        // check for login/register
        $register = $this->$oauthType->register($post, $address);

        $user = $register['user'];
        // select only what is needed
        $user = $this->indUser
            ->select(array(
                'userId',
                'userGenderId',
                'userCountryISO',
                'userAddressId',
                'userAddressCoordinate',
                'userDynamicAddressCoordinate',
                'userFname',
                'userLname',
                'userEmail',
                'userDOB',
                'userOauthId',
                'userOauthType',
                'userPic',
                'userRegDate'))
            ->where('userId', '=', $user->userId)
            ->first();

        // create cache for user
        $this->indUserCacheHandler->make($user, 'basic', $user->userId);

        if ($register['action'] == 'register') {

            $this->indDefaultSetting->init($user->userId);

            // fire event when user sign up
            \Event::fire('indUser.register', $user);
        }

        // set user locale and timezone
        $preference = IndPreference::selectPreferenceByUserId($user->userId);
        if ($preference) {
            $userLang = json_decode($preference->preferenceData)->langCode;
            \CustomHelper::setUserLocaleTimeZone($user->userAddressId, $userLang);
        }

        // return master cache
        return $this->userMasterCache->init('ind', $user->userId);
    }
} 