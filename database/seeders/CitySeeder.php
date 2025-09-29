<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('source/iranyitoszamok.csv');

        $file = fopen($csvPath, 'r');
        $firstLine = true;

        $length = count(file($csvPath));
        $this->command->getOutput()->progressStart($length);

        while (($row = fgetcsv($file,separator: ";")) !== FALSE) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            
            try {
                $county_id = County::where('name', $row[2])->select('id')->get()[0]['id'];
            } catch (\Exception $e){
                dd($row);
            
                dd($e->getMessage());
            }

            if ($row[0] == "" || $row[1] == "") {
                continue;
            }

            $city = City::where('name', $row[1])->first();
            if (!$city['name']) {
                City::insert([
                    'postal_code' => $row[0],
                    'name' => $row[1],
                    'county_id' => $county_id
                ]);
            }
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }
}
