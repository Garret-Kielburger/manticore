<?php

use Illuminate\Database\Seeder;
use Manticore\User as User;
use Manticore\OauthClient as OauthClient;

class userDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'fredbombadil@gmail.com',
            'username' => 'Freddy',
            'password' => bcrypt('12345678'),
            'first_name' => 'Freddy',
            'last_name' => 'Bombadil',
            'street_number' => '123',
            'street_name' => 'Milky Way',
            'province_or_state' => 'Ontario',
            'postal_or_zip_code' => 'A1B 2C3',
            'country_code' => 'Canada',


        ]);

        OauthClient::create([
            'id' => "20d3de22-631f-11e6-acc6-08002777c33d",
            'secret' => "27165cd9-5cb9-47c8-bf1d-f9b71644bc8a",
            'name' => "3a6c458b-e7c0-4d33-960b-4d4a671da146"
        ]);

    }
}
