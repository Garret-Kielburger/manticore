<?php

namespace Manticore\Jobs;

use Manticore\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Manticore\GcmUser;
use Manticore\App;


class PushSync extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($app_uuid)
    {
        $this->app_uuid = $app_uuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    //todo: update with code for new push notifications
    public function handle()
    {
        $app = App::where('uuid', $this->app_uuid)->first();

        $GcmUsers = GcmUser::where('app_uuid', $this->app_uuid)->get();

        foreach ($GcmUsers as $GcmUser)
        {
            $ppl[] = PushNotification::Device($GcmUser->regId);
            //$devices[] = $GcmUser->regId;
        }
        $message = "Sync the db";

        $message1 = array("data" => array(
            "todo" => $message));

        // Code to send to all gcmusers registered with app

        $allToSend = PushNotification::DeviceCollection($ppl);

        $collection = PushNotification::app(['environment' => 'production',
            'apiKey' => $app->app_api_key,
            'service' => 'gcm'])->to($allToSend);

        $collection->adapter->setAdapterParameters(['sslverifypeer' => false]);

        $collection->send($message, ['collapse_key'=>'collapse']);





        /*
        // This is the code for sending messages to single device with manually set regId
        $regId = '';
        PushNotification::app(['environment' => 'production',
            'apiKey' => '',
            'service' => 'gcm'])->to($regId)->send($message, ['collapse_key'=>'collapse']);*/

    }
}
