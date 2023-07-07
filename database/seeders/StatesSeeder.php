<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert(['name' => 'Andaman and Nicobar Islands']);
        DB::table('states')->insert(['name' => 'Andhra Pradesh']);
        DB::table('states')->insert(['name' => 'Arunachal Pradesh']);
        DB::table('states')->insert(['name' => 'Assam']);
        DB::table('states')->insert(['name' => 'Bihar']);
        DB::table('states')->insert(['name' => 'Chandigarh']);
        DB::table('states')->insert(['name' => 'Chhattisgarh']);
        DB::table('states')->insert(['name' => 'Dadra and Nagar Haveli']);
        DB::table('states')->insert(['name' => 'Daman and Diu']);
        DB::table('states')->insert(['name' => 'Delhi']);
        DB::table('states')->insert(['name' => 'Goa']);
        DB::table('states')->insert(['name' => 'Gujarat']);
        DB::table('states')->insert(['name' => 'Haryana']);
        DB::table('states')->insert(['name' => 'Himachal Pradesh']);
        DB::table('states')->insert(['name' => 'Jammu and Kashmir']);
        DB::table('states')->insert(['name' => 'Jharkhand']);
        DB::table('states')->insert(['name' => 'Karnataka']);
        DB::table('states')->insert(['name' => 'Kerala']);
        DB::table('states')->insert(['name' => 'Ladakh']);
        DB::table('states')->insert(['name' => 'Lakshadweep']);
        DB::table('states')->insert(['name' => 'Madhya Pradesh']);
        DB::table('states')->insert(['name' => 'Maharashtra']);
        DB::table('states')->insert(['name' => 'Manipur']);
        DB::table('states')->insert(['name' => 'Meghalaya']);
        DB::table('states')->insert(['name' => 'Mizoram']);
        DB::table('states')->insert(['name' => 'Nagaland']);
        DB::table('states')->insert(['name' => 'Odisha']);
        DB::table('states')->insert(['name' => 'Puducherry']);
        DB::table('states')->insert(['name' => 'Punjab']);
        DB::table('states')->insert(['name' => 'Rajasthan']);
        DB::table('states')->insert(['name' => 'Sikkim']);
        DB::table('states')->insert(['name' => 'Tamil Nadu']);
        DB::table('states')->insert(['name' => 'Telangana']);
        DB::table('states')->insert(['name' => 'Tripura']);
        DB::table('states')->insert(['name' => 'Uttar Pradesh']);
        DB::table('states')->insert(['name' => 'Uttarakhand']);
        DB::table('states')->insert(['name' => 'West Bengal']);
    }
}
