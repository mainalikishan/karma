<?php
/**
 * User: Prakash
 * Date: 10/10/14
 * Time: 8:55 PM
 */

namespace Karma\Jobs;

use Laracasts\Validation\FormValidator;

class JobsValidate extends FormValidator {

    /**
     * Validation rules for logging in
     *
     * @var array
     */
    protected $rules = [
        'jobUserId' => 'required',
        'jobCountryId' => 'required',
        'jobAddressId' => 'required',
        'jobSummary' => 'required',
        'jobTitle' => 'required',
        'jobTypeId' => 'required',
        'jobOpen' => 'required',
        'jobSkills' => 'required',
        'jobExpDate' => 'required',
        'jobExp' => 'required'
    ];
} 