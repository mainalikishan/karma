<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 12:20 PM
 */

namespace Karma\Profile\Review;

use Carbon\Carbon;
use Karma\Hire\IndHire;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Notification\IndNotificationHandler;

class IndReviewHandler
{

    /**
     * @var IndReview
     */
    private $indReview;
    /**
     * @var \Karma\Hire\IndHire
     */
    private $indHire;
    /**
     * @var \Karma\Notification\IndNotificationHandler
     */
    private $indNotificationHandler;

    public function __construct(
        IndReview $indReview,
        IndHire $indHire,
        IndNotificationHandler $indNotificationHandler
    )
    {
        $this->indReview = $indReview;
        $this->indHire = $indHire;
        $this->indNotificationHandler = $indNotificationHandler;
    }

    public function addReview($post)
    {

        // check post array  fields
        \CustomHelper::postCheck($post,
            array(
                'userToken' => 'required',
                'reviewToId' => 'required|integer',
                'reviewById' => 'required|integer',
                'reviewRatingValue' => 'required',
                'reviewText' => 'optional',
                'reviewUserType' => 'required|enum=indUser,copUser'
            ),
        6);

        $user = \CustomHelper::postRequestUserDetailCheck($post->reviewUserType, $post->userToken, $post->reviewById);

        // getting post value
        $reviewById = $post->reviewById;
        $reviewToId = $post->reviewToId;
        $reviewText = $post->reviewText;
        $reviewRatingValue = $post->reviewRatingValue;


        // check hire or not
        if (!$this->indHire->isHired($reviewById, $reviewToId, $user['type'])) {
            return false;
        }

        if (!$this->indReview->isReviewed($reviewById, $reviewToId, $user['type'])) {

            // add Review and rating
            $review = IndReview::create(array(
                'reviewById' => $reviewById,
                'reviewToId' => $reviewToId,
                'reviewUserType' => $user['type'],
                'reviewText' => $reviewText,
                'reviewRatingValue' => $reviewRatingValue,
                'reviewAddedDate' => Carbon::now(),
                'reviewUpdatedDate' => Carbon::now()
            ));

            // set internal log
            if($user['type'] == 'cop') {
                CopInternalLogHandler::addInternalLog($reviewById, $post);
            } else {
                IndInternalLogHandler::addInternalLog($reviewById, $post);
            }

            // now add to notification
            $message = "<strong>" . $user['name'] . "</strong>" . " reviewed your profile";
            $this->indNotificationHandler->addNotification(
                $userId = $reviewToId,
                $details = $message,
                $type = '_PROFILE_REVIEW_',
                $targetId = $review->reviewId
            );

            return array('success' => \Lang::get('messages.profile.review.review_successful'), 'data' => $post);
        }

        // oh o...already reviewed
        return false;
    }
}