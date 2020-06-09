<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User;
        $user->name = "Surveyor";
        $user->email = "surveyor@digjaya.com";
        $user->password = Hash::make("A1d2m3i4n5");
        $user->api_token = Str::random(100);

        $user->save();
    }
}
