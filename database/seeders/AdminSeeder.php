<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Admin_AYA',
            'email'=>'aya35@gmail.com',
            'phone'=>'0963852741',
            'password'=>'123456#Aa',
            'role'=>'admin',
            'picture_url'=>'images/1715019183_photo_٢٠٢٣-٠٧-٢٦_١٥-٢٦-٤٤.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
