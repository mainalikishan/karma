<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 3:31 PM
 */

namespace Karma\Review\Events;

use Karma\Review\Mailer\IndReviewMailer;

class IndReviewEventsHandler
{
    /**
     * @var \Karma\Review\Mailer\IndReviewMailer
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
        $events->listen('profile.review', 'Karma\Review\Events\IndReviewEventsHandler@onReview');
    }

} 