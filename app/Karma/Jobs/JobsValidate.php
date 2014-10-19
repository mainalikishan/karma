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
        'jobTitle' => 'required',
        'jobTypeId' => 'required',
        'jobProfessionId'=>'required',
        'jobSkills' => 'required',
        'jobExp' => 'required',
        'jobOpen' => 'required',
        'jobSummary' => 'required',
        'jobExpDate' => 'required'
    ];
} 