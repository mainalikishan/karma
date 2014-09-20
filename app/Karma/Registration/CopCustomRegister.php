<?php
/**
 * Created by PhpStorm.
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Registration;


class CopCustomRegister implements CopUserRegisterInterface {

    function register()
    {
        return "custom login success";
    }
} 