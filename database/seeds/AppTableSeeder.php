<?php

use Illuminate\Database\Seeder;
use Manticore\User as User;
use Manticore\App as App;
use Manticore\NavigationStyle as NavigationStyle;


class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $app1 = App::create([
            'app_name' => 'Test App 1',
            'user_uuid' => $user->uuid,
            'navigation_id' => 3
        ]);

        NavigationStyle::create([
            'app_uuid' => $app1->uuid
        ]);
    }
}
