<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 12:14 PM
 */

namespace Karma\Profile\Review;


use Carbon\Carbon;

class IndReview extends \Eloquent
{

    const CREATED_AT = 'reviewAddedDate';
    const UPDATED_AT = 'reviewUpdatedDate';

    protected $primaryKey = 'reviewId';

    //database table ind_profile_review
    protected $table = 'ind_profile_review';

    protected $fillable = ['reviewById',
        'reviewToId',
        'reviewUserType',
        'reviewText',
        'reviewRatingValue',
        'reviewReportCount',
        'reviewReportStatus'
    ];

    public function isReviewed($reviewById, $reviewToId, $reviewUserType)
    {
        $review = $this->where('reviewById', $reviewById)
            ->where('reviewToId', $reviewToId)
            ->where('reviewUserType', $reviewUserType)
            ->first();
        if($review) {
            return true;
        }
        else {
            return false;
        }
    }

    public function reviewCheckById($id)
    {
        return $this->where('reviewId', $id)
            ->count();
    }

    public function updateReviewCount($id)
    {
        $review = $this->find($id);
        $review->reviewReportCount = $review->reviewReportCount + 1;
        $review->reviewReportStatus = ($review->reviewReportCount == MAX_REVIEW_REPORT_COUNT) ? 'Y' : 'N';
        $review->reviewUpdatedDate = Carbon::now();
        $review->save();
    }
} 