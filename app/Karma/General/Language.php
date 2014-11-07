<?php
/**
 * User: kishan
 * Date: 11/7/14
 * Time: 12:29 PM
 */

namespace Karma\General;


class Language extends \Eloquent
{
    const CREATED_AT = 'languageAddedDate';
    const UPDATED_AT = 'languageUpdatedDate';
    protected $primaryKey = 'languageId';

    protected $fillable = array(
        'languageName',
        'languageCode'
    );

    protected $table = 'language';


    /**
     * @param $languageName
     * @param $languageCode
     * @return static
     */
    public static function createLang($languageName, $languageCode)
    {
        $lang = new static (compact('languageName', 'languageCode'));
        return $lang;
    }


    /**
     * @return mixed
     */
    public static function selectLangAll()
    {
        return
            self::select(array('languageName', 'languageCode'))
            ->get();
    }


    /**
     * @param $languageCode
     * @return bool
     */
    public static function selectLang($languageCode)
    {
        $lang =
            self::select(array('languageId', 'languageName', 'languageCode'))
            ->where(compact('languageCode'))
            ->first();
        if ($lang) {
            return $lang;
        }
        return false;
    }

}