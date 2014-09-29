<?php
/**
 * User: Kishan
 * Date: 9/20/14
 * Time: 12:19 PM
 */
namespace Karma\Registration;

use Karma\Cache\IndUserCacheHandler;
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

    public function __construct(IndFacebookRegister $indFacebookRegister,
                                IndTwitterRegister $indTwitterRegister,
                                IndLinkedinRegister $indLinkedinRegister,
                                IndUser $indUser,
                                IndUserCacheHandler $indUserCacheHandler)
    {

        $this->indFacebookRegister = $indFacebookRegister;
        $this->indTwitterRegister = $indTwitterRegister;
        $this->indLinkedinRegister = $indLinkedinRegister;
        $this->indUser = $indUser;
        $this->indUserCacheHandler = $indUserCacheHandler;
    }

    public function checkRegistration($post)
    {
        $oauthType = $post->oauthType;
        if ($oauthType !== 'indFacebookRegister'
            && $oauthType !== 'indTwitterRegister'
            && $oauthType !== 'indLinkedinRegister'
        ) {
            throw new \Exception('Illegal oauth type');
        }

        // check for login/register
        $user = $this->$oauthType->register($post);

        // select only what is needed
        $user = $this->indUser
            ->select(array(
                'userId',
                'userGenderId',
                'userCountryId',
                'userAddressId',
                'userJobTitleId',
                'userFname',
                'userLname',
                'userEmail',
                'userDOB',
                'userOauthId',
                'userOauthType',
                'userSummary',
                'userPic',
                'userRegDate'))
            ->where('userId', '=', $user->userId)
            ->first();

        // create cache for user
        $return = $this->indUserCacheHandler->make($user, 'basic', $user->userId);
        return $return;
    }
} 