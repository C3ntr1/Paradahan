<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlotTypeSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            'Small' => '20',
            'Medium' => '60',
            'Large' => '100'
        ];

        foreach ($sizes as $key => $value) {
            \App\Models\SlotType::create([
                'name' => $key,
                'price' => $value,
            ]);
        }
    }
}
