<?php

namespace Manticore\Jobs;

use Manticore\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Manticore\App;
use Manticore\GcmUser;
use Edujugon\PushNotification\Facades\PushNotification;



class PushMessage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($app_uuid, Request $request)
    {
        $this->app_uuid = $app_uuid;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $GcmUsers = GcmUser::where('app_uuid', $this->app_uuid)->get();

        $app = App::where('uuid', $this->app_uuid)->first();

//        $count = GcmUser::where('app_uuid', $this->app_uuid)->count();

        // $userID = $GcmUsers->regID;


        /**
         * Dummy array for the purpose testing on multiple devices
         */
        $ppl = [];

        /**
         * Iterate over registered users and populate array with registered device tokens
         */

        foreach ($GcmUsers as $GcmUser)
        {
            //$userID = $GcmUser->regId;
            $ppl[] = PushNotification::Device($GcmUser->regId);
        }
//        $myId2 = $GcmUsers->toArray();

        //$message = Request::all();
        $request = $this->request;
        $body = $request->input('text_msg');

       // $message1 = array("price" => $body);

        $message = array("notification" => array(
            "title" => "Message from Internet",
            "body" => $body,
            "icon" => "icon"));

        /**
         * DeviceCollection working
         */

        // todo: replace with new push notification code

        $allToSend = PushNotification::DeviceCollection($ppl);

        $one = "dvmWw739NFY:APA91bF48kMQOMTXX0Vbpj06HlLQOAgTOG5aiVxlWYgfrD5VMITP1BiGl2mLsXsLhygQrdZVMhchmO14owv3CVdmhYyLEbd5Em7W7UDluseuysEsSp64-3VSM_xU3pfWbiL3NRTTYfVE";

        // push sync to use dynamic app api-key --> use app_uuid to get it in constructor

        $collection = PushNotification::app(['environment' => 'production',
            'apiKey' => $app->app_api_key,
            'service' => 'gcm'])->to($one);

        $collection->adapter->setAdapterParameters(['sslverifypeer' => false]);

        $collection->send($message, ['collapse_key'=>'collapse']);


        // Good method, but runs from config file - ie unchangeable for each app
        /*$collection = PushNotification::app('appNameAndroid')
            ->to($allToSend)
            ->send($count);*/
    }
}
