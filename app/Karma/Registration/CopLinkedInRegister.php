<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:35 PM
 */

namespace Karma\Registration;


class CopLinkedInRegister implements CopUserRegisterInterface
{
    function __construct()
    {
    }

    public function register($data)
    {
        return $this->category->fill($data)->save();
        return "success linked in";
    }
}