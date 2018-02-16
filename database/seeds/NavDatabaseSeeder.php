<?php

use Illuminate\Database\Seeder;
use Manticore\Navigation as Navigation;

class NavDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Navigation::create([
           'navigation' => 'Bottom Tabs'
        ]);

        Navigation::create([
           'navigation' => 'Swipe Tabs'
        ]);

        Navigation::create([
           'navigation' => 'Navigation Drawer'
        ]);
    }
}
