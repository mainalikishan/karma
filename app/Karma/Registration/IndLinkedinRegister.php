<?php
/**
 * User: kishan
 * Date: 9/20/14
 * Time: 2:43 PM
 */

namespace Karma\Registration;


class IndLinkedinRegister implements IndUserRegisterInterface
{
    public function register($post)
    {
        return "linkedin";
    }
} 