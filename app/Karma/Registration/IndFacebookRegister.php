<?php
/**
 * User: kishan
 * Date: 9/20/14
 * Time: 1:33 PM
 */

namespace Karma\Registration;


class IndFacebookRegister implements IndUserRegisterInterface
{

    public function register()
    {
        return "facebook";
    }
}