<?php

use Illuminate\Database\Seeder;
use Manticore\Screen as Screen;
use Manticore\Image as Image;

class ImageTableSeeder extends Seeder
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
        Image::create([
            'screen_uuid'  => $screen->uuid,
            'purpose' => 'logo',
            'uri' => 'http://randomprojecttest.tk/storage/uploads/bills.png'
        ]);

        Image::create([
            'screen_uuid'  => $screen2->uuid,
            'purpose' => 'logo',
            'uri' => 'http://randomprojecttest.tk/storage/uploads/packers.jpg'
        ]);

    }
}
