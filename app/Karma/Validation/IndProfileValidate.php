<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 12:30 PM
 */

namespace Karma\Validation;


use Laracasts\Validation\FormValidator;

class IndProfileValidate extends FormValidator
{

    /**
     * Validation rules for logging in
     *
     * @var array
     */
    protected $rules = [
        'fname' => 'required'
    ];

}