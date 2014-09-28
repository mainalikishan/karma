<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 12:19 PM
 */

namespace Karma\Registration;


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

    public function __construct(CopCustomRegister $copCustomRegister, CopLinkedInRegister $copLinkedInRegister)
    {
        $this->copCustomRegister = $copCustomRegister;
        $this->copLinkedInRegister = $copLinkedInRegister;
    }

    public function checkRegistration($post)
    {
        $oauthType = $post->userOuthType;
        if ($oauthType !== 'copCustomRegister'
            && $oauthType !== 'copLinkedInRegister'
        ) {
            throw new \Exception('Illegal ouath type');
        }
        return $this->$oauthType->register($post);
    }

}