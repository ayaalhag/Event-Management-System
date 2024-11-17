<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $startTime = Carbon::now();

        $this->call([
            AdminSeeder::class,
            StatusSeeder::class,
        ]);
        DB::table('types')->insert([
            'name'=>'aa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name'=>'aa',
            'email'=>'a7@email.com',
            'phone'=>'1',
            'password'=>'a2541a',
            'role'=>'user',
            'balance'=>'0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);
        DB::table('catgories_part')->insert([
            'name'=>'aa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);        
        DB::table('parts')->insert([
            'catgory_part_id'=>'1',
            'name'=>'aa',
            'price'=>'1',
            'pictture_url'=>'aa',
            'assessment'=>'1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('catgories_place')->insert([
            'name'=>'aa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);        
        DB::table('places')->insert([
                 'name'=>'2', 
                 'location'=>'aa', 
                 'phone'=>'1', 
                 'assessment'=>'1',
                 'category_place_id'=>'1',
                 'picture_url'=>'images/1716057644_photo_2024-04-25_21-31-49.jpg',
                 'created_at' => Carbon::now(),
                 'updated_at' => Carbon::now()
                ]);

        DB::table('prices')->insert([
            'place_id'=>'1', 
            'price'=>'50', 
            'start_time'=>' 6:00:00', 
            'end_time'=>'8:30:00', 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);      
    }
}
