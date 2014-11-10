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
                'hireByUserType' => 'required|enum=ind,cop',
                'postRequestBy' => 'required|enum=indUser,copUser'
            ),
        6);

        $user = \CustomHelper::postRequestUserDetailCheck($post->postRequestBy, $post->token, $post->userId);

        $hire = $this->indHire->checkHireById($post->hireById, $post->hireToId, $post->hireByUserType);
        if ($hire) {
            $hire->hireRequest = $hire->hireRequest=='N'? 'Y': 'N';
            $hire->hireRequestDate = Carbon::now();
        } else {
            $hire =
                $this->indHire->createHire(
                    $post->hireById,
                    $post->hireToId,
                    $post->hireByUserType,
                    'Y',
                    Carbon::now()
                );
        }
        $hire->save();

        // set internal log
        if ($user['type'] == 'cop') {
            CopInternalLogHandler::addInternalLog($post->userId, $post);
        } else {
            IndInternalLogHandler::addInternalLog($post->userId, $post);
        }

        // now add to notification
        $message = "<strong>" . $user['name'] . "</strong>" . " sent you a hire request";
        $this->indNotificationHandler->addNotification(
            $userId = $post->hireToId,
            $details = $message,
            $type = '_HIRE_REQUEST_',
            $targetId = $hire->hireId
        );
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
                'hireByUserType' => 'required|enum=ind,cop',
                'hireResponse' => 'required|enum=Accept,Ignore',
                'postRequestBy' => 'required|string'
            ),
         7);

        $user = \CustomHelper::postRequestUserDetailCheck($post->postRequestBy, $post->token, $post->userId);

        $hire = $this->indHire->checkHireById($post->hireById, $post->hireToId, $post->hireByUserType);
        if ($hire && $hire->hireRequest=='Y') {
            $hire->hireResponse = $post->hireResponse;
            $hire->hireResponseDate = Carbon::now();
            $hire->save();

            // set internal log
            if ($user['type'] == 'cop') {
                CopInternalLogHandler::addInternalLog($post->userId, $post);
            } else {
                IndInternalLogHandler::addInternalLog($post->userId, $post);
            }

            // now add to notification
            $message = "<strong>" . $user['name'] . "</strong>" . " accepted your hire request";
            $notificationHandler = $post->hireByUserType=='copUser'? 'copNotificationHandler': 'copNotificationHandler';
            $this->$notificationHandler->addNotification(
                $userId = $post->hireById,
                $details = $message,
                $type = '_HIRE_REQUEST_ACCEPTED_',
                $targetId = 0
            );

            return true;
        } else {
            throw new \Exception(\Lang::get('errors.something_went_wrong'));
        }
    }

}