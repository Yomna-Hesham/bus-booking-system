<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $stations = file_get_contents(public_path("egypt_cities.json"));
        $stations = json_decode($stations);

        foreach ($stations as $station){
            DB::table("stations")->insert(["name" => $station]);
        }
    }
}
