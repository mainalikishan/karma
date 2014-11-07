<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 3:31 PM
 */

namespace Karma\Profile\Review\Events;

use Karma\Profile\Review\Mailer\IndReviewMailer;

class IndReviewEventsHandler
{
    /**
     * @var \Karma\Profile\Review\Mailer\IndReviewMailer
     */
    private $indReviewMailer;

    public function __construct(IndReviewMailer $indReviewMailer)
    {
        $this->indReviewMailer = $indReviewMailer;
    }


    /**
     * @param $data
     */
    public function onReview($data)
    {
        $this->indReviewMailer->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('profile.review', 'Karma\Profile\Review\Events\IndReviewEventsHandler@onReview');
    }

} 