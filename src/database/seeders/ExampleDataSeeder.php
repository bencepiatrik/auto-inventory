<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Part;

class ExampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // --- CARS (5 ks) ---
        $cars = [
            ['name' => 'Škoda Octavia',  'is_registered' => true,  'registration_number' => 'NR123AB',  'created_at'=>$now,'updated_at'=>$now],
            ['name' => 'VW Golf',        'is_registered' => true,  'registration_number' => 'BA456CD',  'created_at'=>$now,'updated_at'=>$now],
            ['name' => 'Toyota Corolla', 'is_registered' => false, 'registration_number' => null,       'created_at'=>$now,'updated_at'=>$now],
            ['name' => 'Hyundai i30',    'is_registered' => true,  'registration_number' => 'TT789EF',  'created_at'=>$now,'updated_at'=>$now],
            ['name' => 'Kia Ceed',       'is_registered' => false, 'registration_number' => null,       'created_at'=>$now,'updated_at'=>$now],
        ];
        Car::insert($cars);

        // Mapovanie názvu -> id (aby sa nám jednoducho pripájali diely)
        $carId = Car::pluck('id', 'name');

        // --- PARTS (20 ks) ---
        $parts = [
            // Škoda Octavia
            ['name'=>'Alternátor',        'serialnumber'=>'ALT-0001', 'quantity'=>1, 'car'=>'Škoda Octavia'],
            ['name'=>'Olejový filter',    'serialnumber'=>'OF-0002',  'quantity'=>2, 'car'=>'Škoda Octavia'],
            ['name'=>'Brzdové doštičky',  'serialnumber'=>'BD-0003',  'quantity'=>1, 'car'=>'Škoda Octavia'],
            ['name'=>'Zapaľovacia sviečka','serialnumber'=>'ZS-0004', 'quantity'=>4, 'car'=>'Škoda Octavia'],

            // VW Golf
            ['name'=>'Vzduchový filter',  'serialnumber'=>'VF-0005',  'quantity'=>1, 'car'=>'VW Golf'],
            ['name'=>'Palivový filter',   'serialnumber'=>'PF-0006',  'quantity'=>1, 'car'=>'VW Golf'],
            ['name'=>'Lambda sonda',      'serialnumber'=>'LS-0007',  'quantity'=>1, 'car'=>'VW Golf'],
            ['name'=>'Rozvody (sada)',    'serialnumber'=>'RZ-0008',  'quantity'=>1, 'car'=>'VW Golf'],

            // Toyota Corolla
            ['name'=>'Vodná pumpa',       'serialnumber'=>'WP-0009',  'quantity'=>1, 'car'=>'Toyota Corolla'],
            ['name'=>'Chladič',           'serialnumber'=>'CH-0010',  'quantity'=>1, 'car'=>'Toyota Corolla'],
            ['name'=>'Termostat',         'serialnumber'=>'TS-0011',  'quantity'=>1, 'car'=>'Toyota Corolla'],
            ['name'=>'Senzor ABS',        'serialnumber'=>'ABS-0012', 'quantity'=>2, 'car'=>'Toyota Corolla'],

            // Hyundai i30
            ['name'=>'Spojková sada',     'serialnumber'=>'SS-0013',  'quantity'=>1, 'car'=>'Hyundai i30'],
            ['name'=>'Tlmič',             'serialnumber'=>'TL-0014',  'quantity'=>2, 'car'=>'Hyundai i30'],
            ['name'=>'Turbodúchadlo',     'serialnumber'=>'TB-0015',  'quantity'=>1, 'car'=>'Hyundai i30'],
            ['name'=>'EGR ventil',        'serialnumber'=>'EGR-0016', 'quantity'=>1, 'car'=>'Hyundai i30'],

            // Kia Ceed
            ['name'=>'ECU riadiaca jednotka', 'serialnumber'=>'ECU-0017','quantity'=>1, 'car'=>'Kia Ceed'],
            ['name'=>'Katalyzátor',       'serialnumber'=>'KT-0018',  'quantity'=>1, 'car'=>'Kia Ceed'],
            ['name'=>'Remenica',          'serialnumber'=>'RM-0019',  'quantity'=>1, 'car'=>'Kia Ceed'],
            ['name'=>'Modul prevodovky',  'serialnumber'=>'MP-0020',  'quantity'=>1, 'car'=>'Kia Ceed'],
        ];

        $rows = [];
        foreach ($parts as $p) {
            $rows[] = [
                'name'         => $p['name'],
                'serialnumber' => $p['serialnumber'],
                'quantity'     => $p['quantity'],
                'car_id'       => $carId[$p['car']] ?? null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        Part::insert($rows);
    }
}
