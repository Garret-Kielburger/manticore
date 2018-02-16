<?php

use Illuminate\Database\Seeder;
use Manticore\App as App;
use Manticore\Screen as Screen;

class ScreenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = App::find(1);
        Screen::create([
            'screen_name' => 'Welcome',
            'app_uuid' => $app->uuid,
            'screen_order_number' => '1'
        ]);

        Screen::create([
            'screen_name' => 'Contacts',
            'app_uuid' => $app->uuid,
            'screen_order_number' => '2'

        ]);


    }
}
