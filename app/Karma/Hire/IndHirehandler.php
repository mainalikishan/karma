<?php
/**
 * User: kishan
 * Date: 11/9/14
 * Time: 11:22 AM
 */

namespace Karma\Hire;


use Carbon\Carbon;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Notification\CopNotificationHandler;
use Karma\Notification\IndNotificationHandler;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

class IndHirehandler
{

    /**
     * @var IndHire
     */
    private $indHire;
    /**
     * @var \Karma\Notification\IndNotificationHandler
     */
    private $indNotificationHandler;
    /**
     * @var \Karma\Notification\CopNotificationHandler
     */
    private $copNotificationHandler;

    public function __construct(
        IndHire $indHire,
        IndNotificationHandler $indNotificationHandler,
        CopNotificationHandler $copNotificationHandler)
    {
        $this->indHire = $indHire;
        $this->indNotificationHandler = $indNotificationHandler;
        $this->copNotificationHandler = $copNotificationHandler;
    }

    public function request($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'hireById' => 'required|integer',
                'hireToId' => 'required|integer',
                'hireByUserType' => 'required|enum=indUser,copUser',
                'postRequestBy' => 'required|string'
            ),
        5);

        $user = \CustomHelper::postRequestUserDetailCheck($post->postRequestBy, $post->token, $post->userId);

        $hire = $this->indHire->isHired($post->hireById, $post->hireToId, $user['type']);
        if ($hire) {
            $hire->hireRequest = 'N';
        } else {
            $hire =
                $this->indHire->createHire(
                    $post->hireById,
                    $post->hireToId,
                    $user['type'],
                    'Y',
                    Carbon::now()
                );
        }
        $hire->save();

        // set internal log
        if($user['type'] == 'cop') {
            CopInternalLogHandler::addInternalLog($post->userId, $post);
        } else {
            IndInternalLogHandler::addInternalLog($post->userId, $post);
        }

        // now add to notification
        $message = "<strong>" . $user['name'] . "</strong>" . " sent you a hire request";
        $this->$userType->addNotification(
        $userId = $post->hireToId,
        $details = $message,
        $type = '_HIRE_REQUEST_',
        $targetId = $hire->hireId);
        return true;
    }

    public function response($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'hireById' => 'required|integer',
                'hireToId' => 'required|integer',
                'hireByUserType' => 'required|enum=indUser,copUser',
                'hireResponse' => 'required|enum=Accept,Ignore',
                'postRequestBy' => 'required|string'
            ),
            6);

        $user =
            $post->postRequestBy === 'copUser' ?
                CopUser::loginCheck($post->token, $post->userId) :
                IndUser::loginCheck($post->token, $post->userId);

        if (!$user) {
            throw new \Exception(\Lang::get('errors.invalid_token'));
        }

        $post->hireByUserType = $post->hireByUserType == 'copUser' ? 'cop' : 'ind';

        $hire = $this->indHire->isHired($post->hireById, $post->hireToId, $post->hireByUserType);
        if ($hire) {
            $hire->hireResponse = $post->hireResponse;
            $hire->hireResponseDate = Carbon::now();
            $hire->save();
            return true;
        } else {
            throw new \Exception(\Lang::get('errors.something_went_wrong'));
        }
    }

}