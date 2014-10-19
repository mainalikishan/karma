<?php
/**
 * User: Prakash
 * Date: 10/13/14
 * Time: 11:37 PM
 */

namespace Karma\General;


class IndustryType extends  \Eloquent{
    const CREATED_AT = 'industryTypeAddedDate';
    const UPDATED_AT = 'industryTypeUpdatedDate';
    protected $primaryKey = 'industryTypeId';

    protected $fillable = array(
        'industryTypeName'
    );

    // database table used by model
    protected $table = 'industry_type';

    public static function selectGenderName($industryTypeId) {
        $industryType = self::select(array('industryTypeName'))
            ->where(compact('industryTypeId'))
            ->first();
        if($industryType) {
            return $industryType->industryTypeName;
        }
        throw new \Exception(\Lang::get('errors.invalid_industry_type_id'));
    }

} 