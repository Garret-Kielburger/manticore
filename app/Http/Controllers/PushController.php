<?php

namespace Manticore\Http\Controllers;

use Illuminate\Http\Request;
use Manticore\GcmUser;
use Manticore\App;
use Edujugon\PushNotification\Facades\PushNotification;


use Manticore\Http\Requests;

class PushController extends Controller
{
    /*
      *
      *
      * PUSH notification Methods
      *
      *
      *
    */


    // Currently dispatching Jobs to Queue from DashboardController case-switch statement



    /*
     *
     *
     *  Administration -> register
     *
     */

    public function postRegister($app_uuid, Request $request)
    {
        //Need one route for Android (this one) and to make another for iOS if using APN --> or conditional statement
        // todo: incorporate APN registration ==> 2 routes, one for gcm, one for apn
        //$name = $request->input('name');

        if (($request->input('deviceId') != null) && ($request->input('regId') != null))
        {
            $app = App::where('uuid', $app_uuid)->first();

            $deviceId = $request['deviceId'];
            $regId = $request['regId'];

            $existingUser = GcmUser::where('deviceId', $deviceId)->first();

            if ($existingUser){
                $existingUser->regId = $regId;
                $existingUser->save();
            } else {
                $this->storeUser($deviceId, $regId, $app_uuid);
            }

            $message = array("title" => $app->app_name, "body" => "Registered with Firebase", "icon" => "icon");

            //Send notification to $registration_ids with $message payload to indicate success

            // todo: Remove this, as it's only for testing purposes. - Also, use try/catch for APN vs FCM

            PushNotification::setService('fcm2')
                ->setMessage([
                    'notification' => [
                        'title'=>$app->app_name,
                        'body'=>'Registered with Firebase',
                        'sound' => 'default'
                    ]
                  ])
                ->setApiKey($app->app_api_key)
                ->setDevicesToken($regId)
                        ->send()
            ->getFeedback();


        }
        else {
            //todo: exponential backoff --> or place in queue?
            //registration failed, with user details missing
        }
    }

    /*
     *  Push Administration -> store user
     *
     */

    private function storeUser($deviceId, $regId, $app_uuid)
    {
        //todo: prevent duplicate entries by updating deviceId if it exists
        //add user to database
        $userData = [
            'deviceId'=> $deviceId,
            'regId' => $regId,
            'app_uuid' => $app_uuid,
        ];
        GcmUser::create($userData);
    }
//todo: add function for unRegister()
}
