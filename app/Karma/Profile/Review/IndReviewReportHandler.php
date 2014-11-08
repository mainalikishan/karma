<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 1:29 PM
 */

namespace Karma\Profile\Review;

use Carbon\Carbon;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Users\IndUser;

class IndReviewReportHandler
{

    /**
     * @var IndReview
     */
    private $indReview;
    /**
     * @var IndReviewReport
     */
    private $indReviewReport;

    public function __construct(IndReview $indReview, IndReviewReport $indReviewReport)
    {
        $this->indReview = $indReview;
        $this->indReviewReport = $indReviewReport;
    }

    public function reviewReport($data)
    {

        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'logReportById' => 'required',
                'logReviewId' => 'required',
                'logUserType' => 'required',
                'logReportText' => 'optional'
            ),
            5);

        //getting post value
        $userToken = $data->userToken;
        $logReportById = $data->logReportById;
        $logReviewId = $data->logReviewId;
        $type = $data->logUserType;
        $logReportText = $data->logReportText;

        if ($type == 'indUser') {
            //checking for valid token id and user id
            IndUser::loginCheck($userToken, $logReportById);

            //check reviewed or not
            if ($this->indReview->reviewCheckById($logReviewId) < 1) {
                return false;
            }

            if (!$this->indReviewReport->isReported($logReviewId, $logReportById, 'ind')) {

                // add internal log
                CopInternalLogHandler::addInternalLog($logReportById, $data);

                // update Review report count
                $this->indReview->updateReviewCount($logReviewId);

                //add report for Review
                IndReviewReport::create(array(
                    'logReviewId' => $logReviewId,
                    'logReportById' => $logReportById,
                    'logUserType' => 'ind',
                    'logReportText' => $logReportText,
                    'logAddedDate' => Carbon::now(),
                    'logUpdatedDate' => Carbon::now()
                ));

                return \Lang::get('messages.profile.Review.received_report');
            }
            //already reported
            return false;

        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $logReportById);

            //check reviewed or not
            if ($this->indReview->reviewCheckById($logReviewId) < 1) {
                return false;
            }

            if (!$this->indReviewReport->isReported($logReviewId, $logReportById, 'cop')) {

                // add internal log
                CopInternalLogHandler::addInternalLog($logReportById, $data);

                // update Review report count
                $this->indReview->updateReviewCount($logReviewId);

                //add report for Review
                IndReviewReport::create(array(
                    'logReviewId' => $logReviewId,
                    'logReportById' => $logReportById,
                    'logUserType' => 'cop',
                    'logReportText' => $logReportText,
                    'logAddedDate' => Carbon::now(),
                    'logUpdatedDate' => Carbon::now()
                ));

                return \Lang::get('messages.profile.Review.received_report');
            }

            //already reported
            return false;
        }

        return \Lang::get('errors.something_went_wrong');
    }
}