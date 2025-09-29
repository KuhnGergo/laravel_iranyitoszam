<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use SebastianBergmann\Environment\Console;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('source/iranyitoszamok.csv');

        $file = fopen($csvPath, 'r');
        $firstLine = true;
        $counties = [];
        while (($row = fgetcsv($file,separator: ";")) !== FALSE) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            $name = $row[2];
            try {
                $exists = in_array($name,$counties);
            } catch (\Exception $e){
                dd($row);
            
                dd($e->getMessage());
            }
            
            if (!$exists) {
                $counties[] = $name;
                County::insert([
                    'name' => $name,
                ]);
            }
        }

        fclose($file);
    }
}
