<?php

namespace Manticore\Jobs;

use Manticore\Jobs\Job;
use Manticore\Screen;

class AddScreen extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_uuid, $app_uuid)
    {
        $this->user_uuid = $user_uuid;
        $this->app_uuid =  $app_uuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Screen::create([
            'app_uuid' => $this->app_uuid,
            'screen_name' => 'New Screen',
        ]);
    }
}
