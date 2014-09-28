<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 10:42 PM
 */

namespace Karma\Validation;

use Laracasts\Validation\FormValidator;

class CopChangePasswordValidate extends FormValidator
{

    /**
     * Validation rules for logging in
     *
     * @var array
     */
    protected $rules = [
        'newPassword' => 'required',
        'confirmPassword' => 'required'
    ];

}