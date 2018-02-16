<?php

use Illuminate\Database\Seeder;
use Manticore\FontStyleValue as FontStyleValue;

class FontStyleValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FontStyleValue::create([
            'value_to_apply' => 'normal',
            'property_type' => 'font'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'monospace',
            'property_type' => 'font'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'sans_serif',
            'property_type' => 'font'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'serif',
            'property_type' => 'font'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'bold',
            'property_type' => 'style'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'italic',
            'property_type' => 'style'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'bold_italic',
            'property_type' => 'style'
        ]);

        FontStyleValue::create([
            'value_to_apply' => 'normal',
            'property_type' => 'style'
        ]);

    }
}
