<?php

use Illuminate\Database\Seeder;
use Manticore\Screen as Screen;
use Manticore\Text as Text;

class TextTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $screen = Screen::find(1);
        $screen2 = Screen::find(2);
        Text::create([
            'screen_uuid'  => $screen->uuid,
            'purpose' => 'title',
            'content' => 'Welcome to Test App'
        ]);

        Text::create([
            'screen_uuid'  => $screen->uuid,
            'purpose' => 'body',
            'content' => 'This is the coolest app ever. So cool man!'
        ]);

        Text::create([
            'screen_uuid'  => $screen2->uuid,
            'purpose' => 'title',
            'content' => 'Contact Us'
        ]);

        Text::create([
            'screen_uuid'  => $screen2->uuid,
            'purpose' => 'body',
            'content' => 'Here is our contact info'
        ]);

    }
}
