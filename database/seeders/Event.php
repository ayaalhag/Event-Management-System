<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Event extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            "user_id" => '2',
            "type" => 'typetype',
            "place_id" => '3',
            "status_id"=>'1',
            "name" => "event",
            "additions" => "معرض الفن الحديث",
            "nameOnTheCard" => "John Doe",
            "music" => "بيانو حي",
            "picture_url" => "images/MrPYliGRuR2Kh7CdB5naZqOagfYRbTHGvtz15MKm.png",

        ]); DB::table('bookings')->insert([
            'place_id'=>'3',
            'event_id'=>'6',
            'start_date'=>'2024-04-16 2:30:00',
            'end_date'=>'2024-04-16 7:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('event_part')->insert([
            'event_id'=>'6',
            'part_id'=>'1',
            'number'=>'74',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('event_formats')->insert([
            'event_id'=>'6',
            'hour'=>'01:00:00',
            'description'=>'bvbsjanbc ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
