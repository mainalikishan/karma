<?php
/**
 * User: kishan
 * Date: 9/20/14
 * Time: 1:45 PM
 */

namespace Karma\Registration;


class IndTwitterRegister implements IndUserRegisterInterface
{
    public function register()
    {
        return "twitter";
    }
}