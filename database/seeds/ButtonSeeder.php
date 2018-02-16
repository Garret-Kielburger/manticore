<?php

use Illuminate\Database\Seeder;
use Manticore\Screen as Screen;

use Manticore\Button as Button;
use Manticore\ButtonSubscreen as ButtonSubscreen;

class ButtonSeeder extends Seeder
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

        // Plain button, no dialog
        Button::create([
            'screen_uuid'  => $screen->uuid,
            'with_sub_screen' => false,
            'label' => "Email",
            'purpose' => 'email',
            'content' => 'fredbombadil@gmail.com'
        ]);

        // Plain button, no dialog
        Button::create([
            'screen_uuid'  => $screen->uuid,
            'with_sub_screen' => false,
            'label' => "Phone",
            'purpose' => 'phone',
            'content' => '6135551234'
        ]);

        // button, opens dialog
        Button::create([
            'screen_uuid'  => $screen->uuid,
            'with_sub_screen' => true,
            'label' => "Dialog",
            'purpose' => 'dialog',
            'content' => 'open new dialog'
        ]);

        $button = Button::find(3);

        ButtonSubscreen::create([
            'screen_uuid' => $screen->uuid,
            'owning_button_uuid' => $button->uuid,
            'title' => "Open Dialog",
            'purpose' => "dialog"
        ]);

        $subscreen = ButtonSubscreen::find(1);

        $button->sub_screen_uuid = $subscreen->uuid;
        $button->save();

    }
}
