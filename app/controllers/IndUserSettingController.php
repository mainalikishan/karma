<?php
use Karma\Setting\IndPreferenceHandler;

/**
 * User: kishan
 * Date: 10/29/14
 * Time: 9:34 PM
 */
class IndUserSettingController extends ApiController
{


    /**
     * @var Karma\Setting\IndPreferenceHandler
     */
    private $indPreferenceHandler;

    public function __construct(IndPreferenceHandler $indPreferenceHandler)
    {
        $this->indPreferenceHandler = $indPreferenceHandler;
    }

    public function updatePreference() {
        $post = $this->postRequestHandler();
        if(is_object($post))
        {
            try{
                $return = $this->indPreferenceHandler->update($post);
                return $this->respond($return);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


}