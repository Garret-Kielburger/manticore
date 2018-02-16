<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(NavDatabaseSeeder::class);
        $this->call(userDatabaseSeeder::class);
        $this->call(AppTableSeeder::class);
        $this->call(ScreenTableSeeder::class);
        $this->call(TextTableSeeder::class);
        $this->call(ImageTableSeeder::class);
        $this->call(ButtonSeeder::class);
        $this->call(ConstraintTableSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(PropertyTableSeeder::class);
        $this->call(FontStyleValueSeeder::class);

    }
}
