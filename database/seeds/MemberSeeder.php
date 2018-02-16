<?php

use Illuminate\Database\Seeder;
use Manticore\Member as Member;
use Manticore\App as App;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = App::find(1);
        Member::create([
            'username' => 'Franky',
            'email' => 'fredbombadil@gmail.com',
            'app_uuid' => $app->uuid,
            'expiry' => Carbon::createFromDate(2017, 3, 15)->addYear(1)
        ]);

        Member::create([
            'username' => 'Dom',
            'email' => 'heat.ottawa@gmail.com',
            'app_uuid' => $app->uuid,
            'expiry' => Carbon::createFromDate(2017, 3, 15)->addYear(1)
        ]);

        Member::create([
            'username' => 'Kavenator',
            'email' => 'kavenbaker@gmail.com',
            'app_uuid' => $app->uuid,
            'expiry' => Carbon::createFromDate(2017, 3, 15)->addYear(1)
        ]);

    }
}
