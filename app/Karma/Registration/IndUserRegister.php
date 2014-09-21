<?php
/**
 * User: Kishan
 * Date: 9/20/14
 * Time: 12:19 PM
 */
namespace Karma\Registration;


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

    public function __construct(IndFacebookRegister $indFacebookRegister,
                                IndTwitterRegister $indTwitterRegister,
                                IndLinkedinRegister $indLinkedinRegister)
    {

        $this->indFacebookRegister = $indFacebookRegister;
        $this->indTwitterRegister = $indTwitterRegister;
        $this->indLinkedinRegister = $indLinkedinRegister;
    }

    public function checkRegistration($post)
    {
        $oauthType = $post->oauthType;
        if($oauthType!=='indFacebookRegister'
            && $oauthType!=='indTwitterRegister'
            && $oauthType!=='indLinkedinRegister') {
            throw new \Exception('Illegal ouath type');
        }

        return $this->$oauthType->register($post);
    }
} 