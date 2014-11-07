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

    public function addReview($data)
    {

        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'reviewToId' => 'required',
                'reviewById' => 'required',
                'reviewRatingValue' => 'required',
                'reviewText' => 'optional',
                'reviewUserType' => 'required|string'
            ),
            6);

        //getting post value
        $reviewById = $data->reviewById;
        $reviewToId = $data->reviewToId;
        $userToken = $data->userToken;
        $type = $data->reviewUserType;
        $reviewText = $data->reviewText;
        $reviewRatingValue = $data->reviewRatingValue;

        if ($type == 'indUser') {
            //checking for valid token id and user id
            IndUser::loginCheck($userToken, $reviewById);

            //check hire or not
            if ($this->indHire->hiredCheck($reviewById, $reviewToId, 'ind') < 1) {
                return false;
            }

            if ($this->indReview->reviewCheck($reviewById, $reviewToId, 'ind') < 1) {

                // add internal log
                CopInternalLogHandler::addInternalLog($reviewById, $data);

                //add Review and rating
                $review = IndReview::create(array(
                    'reviewById' => $reviewById,
                    'reviewToId' => $reviewToId,
                    'reviewUserType' => 'ind',
                    'reviewText' => $reviewText,
                    'reviewRatingValue' => $reviewRatingValue,
                    'reviewAddedDate' => Carbon::now(),
                    'reviewUpdatedDate' => Carbon::now()
                ));

                //add notification
                $copUser = CopUser::selectNameEmail($data->reviewById);
                $detailsVal = "<strong>" . $copUser['name'] . "</strong>" . " Reviewed your profile";
                if ($reviewText != "") {
                    $detailsVal .= $reviewText;
                }

                $this->indNotificationHandler->addNotification($userId = $reviewToId,
                    $details = $detailsVal,
                    $type = '_PROFILE_REVIEW_',
                    $targetId = $review->reviewById);

            }
            //already reviewed
            return false;

        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $reviewById);

            //check hire or not
            if ($this->indHire->hiredCheck($reviewById, $reviewToId, 'cop') < 1) {
                return false;
            }

            if ($this->indReview->reviewCheck($reviewById, $reviewToId, 'cop') < 1) {

                // add internal log
                CopInternalLogHandler::addInternalLog($reviewById, $data);

                //add Review and rating
                $review = IndReview::create(array(
                    'reviewById' => $reviewById,
                    'reviewToId' => $reviewToId,
                    'reviewUserType' => 'cop',
                    'reviewText' => $reviewText,
                    'reviewRatingValue' => $reviewRatingValue,
                    'reviewAddedDate' => Carbon::now(),
                    'reviewUpdatedDate' => Carbon::now()
                ));

                //add notification
                $copUser = CopUser::selectNameEmail($data->reviewById);
                $detailsVal = "<strong>" . $copUser['name'] . "</strong>" . " Reviewed your profile";
                if ($reviewText != "") {
                    $detailsVal .= $reviewText;
                }

                $this->indNotificationHandler->addNotification($userId = $reviewToId,
                    $details = $detailsVal,
                    $type = '_PROFILE_REVIEW_',
                    $targetId = $review->reviewById);

                return array('success' => \Lang::get('messages.profile.review.review_successful'), 'data' => $data);
            }
            //already reviewed
            return false;
        }

        return \Lang::get('errors.something_went_wrong');
    }
}