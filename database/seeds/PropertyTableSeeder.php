<?php

use Illuminate\Database\Seeder;
use Manticore\PropertyToStyle as PropertyToStyle;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PropertyToStyle::create([
            'property_to_style' => 'text_size'
        ]);

        PropertyToStyle::create([
            'property_to_style' => 'text_color'
        ]);

        PropertyToStyle::create([
            'property_to_style' => 'text_style'
        ]);

        PropertyToStyle::create([
            'property_to_style' => 'font_family'
        ]);

        PropertyToStyle::create([
            'property_to_style' => 'background_color'
        ]);

    }
}
