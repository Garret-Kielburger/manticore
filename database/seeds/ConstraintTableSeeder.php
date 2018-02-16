<?php

use Illuminate\Database\Seeder;
use Manticore\Screen as Screen;
use Manticore\Text as Text;
use Manticore\Image as Image;
use Manticore\Constraint as Constraint;

class ConstraintTableSeeder extends Seeder
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

        $text1screen1 = Text::find(1);
        $text2screen1 = Text::find(2);
        $text1screen2 = Text::find(3);
        $text2screen2 = Text::find(4);

        $image1screen1 = Image::find(1);
        $image1screen2 = Image::find(2);

        // Screen 1
        // Text above image
        Constraint::create([
            'screen_uuid' => $screen->uuid,
            'start_id' => $text1screen1->uuid,
            'start_side' => "BOTTOM",
            'end_id' => $image1screen1->uuid,
            'end_side' => "TOP",
            'margin' => 2
        ]);

        // Image below text
        Constraint::create([
            'screen_uuid' => $screen->uuid,
            'start_id' => $image1screen1->uuid,
            'start_side' => "TOP",
            'end_id' => $text1screen1->uuid,
            'end_side' => "BOTTOM",
            'margin' => 2
        ]);

        // Image above body text
        Constraint::create([
            'screen_uuid' => $screen->uuid,
            'start_id' => $image1screen1->uuid,
            'start_side' => "BOTTOM",
            'end_id' => $text2screen1->uuid,
            'end_side' => "TOP",
            'margin' => 2
        ]);

        // Body text below image
        Constraint::create([
            'screen_uuid' => $screen->uuid,
            'start_id' => $text2screen1->uuid,
            'start_side' => "TOP",
            'end_id' => $image1screen1->uuid,
            'end_side' => "BOTTOM",
            'margin' => 2
        ]);

        // Screen 2
        // Title Text above image
        Constraint::create([
            'screen_uuid' => $screen2->uuid,
            'start_id' => $text1screen2->uuid,
            'start_side' => "BOTTOM",
            'end_id' => $image1screen2->uuid,
            'end_side' => "TOP",
            'margin' => 2
        ]);

        // Image below text
        Constraint::create([
            'screen_uuid' => $screen2->uuid,
            'start_id' => $image1screen2->uuid,
            'start_side' => "TOP",
            'end_id' => $text1screen2->uuid,
            'end_side' => "BOTTOM",
            'margin' => 2
        ]);

        // Image above body text
        Constraint::create([
            'screen_uuid' => $screen2->uuid,
            'start_id' => $image1screen2->uuid,
            'start_side' => "BOTTOM",
            'end_id' => $text2screen2->uuid,
            'end_side' => "TOP",
            'margin' => 2
        ]);

        // Body text below image
        Constraint::create([
            'screen_uuid' => $screen2->uuid,
            'start_id' => $text2screen2->uuid,
            'start_side' => "TOP",
            'end_id' => $image1screen2->uuid,
            'end_side' => "BOTTOM",
            'margin' => 2
        ]);


    }
}
