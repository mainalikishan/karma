<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 10:42 PM
 */

namespace Karma\Validation;

use Laracasts\Validation\FormValidator;

class CopUserForgotPasswordRequestValidate extends FormValidator
{

    /**
     * Validation rules for logging in
     *
     * @var array
     */
    protected $rules = [
        'requestCode' => 'required',
    ];

}