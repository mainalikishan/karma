<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 2:28 PM
 */

namespace Karma\Cache;


class IndUserCacheHandler
{


    /**
     * @var IndUserCacheHandler
     */
    private $indUserCacheHandler;

    public function __construct(IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUserCacheHandler = $indUserCacheHandler;
    }


    public function make($data = [], $updateType, $userId)
    {
        $cache = $this->indUserCacheHandler->find($data->id);
        if ($cache) {
            $cache = json_decode($cache);
        } else {
            $collection = [];
            switch ($updateType) {
                case "basic":
                    $collection['basic'] = $data;
                    break;
                case "experience":
                    $collection['experience'] = $data;
                    break;
                case "education":
                    $collection['education'] = $data;
                    break;
                case "whatIDo":
                    $collection['whatIDo'] = $data;
                    break;
                case "preference":
                    $collection['preference'] = $data;
                    break;
                case "setting":
                    $collection['setting'] = $data;
                    break;
            }
        }
        $cache->userId = $userId;
        $cache->cacheValue = json_encode($collection);
        $return = $cache->save();
        return $return;
    }
}