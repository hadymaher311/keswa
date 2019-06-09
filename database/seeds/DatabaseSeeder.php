<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $admin = new Admin;
        $admin->first_name = "Hady";
        $admin->last_name = "Maher";
        $admin->email = "hadymaher311@gmail.com";
        $admin->password = Hash::make('123456789');
        $admin->save();
    }
}
