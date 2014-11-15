<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 12:20 PM
 */

namespace Karma\Review;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Karma\Hire\IndHire;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Notification\IndNotificationHandler;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

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
                'reviewReportStatus' => 'N',
                'reviewRatingValue' => $reviewRatingValue,
                'reviewAddedDate' => Carbon::now(),
                'reviewUpdatedDate' => Carbon::now()
            ));

            // set internal log
            if ($user['type'] == 'cop') {
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

            return array('success' => Lang::get('messages.profile.review.review_successful'), 'data' => $post);
        }

        // oh o...already reviewed
        return false;
    }

    public function selectReview($post)
    {
        // check post array  fields
        \CustomHelper::postCheck($post,
            array(
                'userToken' => 'required',
                'userId' => 'required|integer', // ind user id
                'reviewId' => 'required|integer' // target ID
            ),
            3);

        // login check
        $user = IndUser::loginCheck($post->userToken, $post->userId);
        if ($user) {
            $result = $this->indReview->getReview($post->reviewId);

            if ($result) {
                if($result->reviewUserType=='cop') {
                    $user = CopUser::selectNameEmail($result->reviewById);
                }
                else {
                    $user = IndUser::selectNameEmail($result->reviewById);
                }
                return array(
                    'reviewId' => $result->reviewId,
                    'userId' => $result->reviewById,
                    'userName' => $user['name'],
                    'reviewText' => $result->reviewText,
                    'ratingPoint' => $result->reviewRatingValue,
                    'reviewReportCount' => $result->reviewRatingValue,
                    'date' => \CustomHelper::humanDate($result->reviewAddedDate)
                );
            }
            return Lang::get('errors.global.temporarily_unavailable');
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }
}