<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 7:50 AM
 */

namespace Karma\Validation;

use Laracasts\Validation\FormValidator;

class CopUserForgotPasswordCodeVerifyValidate extends FormValidator
{

    protected $rules = [
        'userEmail' => 'required',
        'userCode' => 'required|integer'
    ];

}