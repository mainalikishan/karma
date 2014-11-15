<?php
/**
 * User: Prakash
 * Date: 10/30/14
 * Time: 9:22 PM
 */

namespace Karma\Review\Mailer;


use Karma\Users\CopUser;
use Karma\Users\IndUser;

class IndReviewMailer
{

    private $fromName = '';
    private $toName = '';
    private $toEmail = '';
    private $reviewSummary = '';

    /**
     * @param $data
     */
    public function sendEmail($data)
    {
        if ($data->reviewUserType == 'copUser') {
            //from
            $copUser = CopUser::selectNameEmail($data->reviewById);
            $this->fromName = $copUser['name'];

            //to
            $indUser = IndUser::selectNameEmail($data->reviewToId);
            $this->toName = $indUser['name'];
            $this->toEmail = $copUser['email'];

        } else if ($data->reviewUserType == 'indUser') {
            //from
            $indUser = IndUser::selectNameEmail($data->reviewById);
            $this->fromName = $indUser['name'];

            //to
            $indUserTo = IndUser::selectNameEmail($data->reviewToId);
            $this->toEmail = $indUserTo['email'];
            $this->toName = $indUserTo['name'];
        }

        $this->reviewSummary = $data->reviewText;

        \Mail::send('emails.ProfileReview.indReview',
            array('toName' => $this->toName,
                'fromName' => $this->fromName,
                'reviewSummary' => $this->reviewSummary,
                'logo' => DEFAULT_EMAIL_LOGO,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->toName)->subject($this->fromName . " reviewed your profile ");
            });
    }
} 