<?php

namespace Database\Seeders;

use App\Models\RequestType;
use Illuminate\Database\Seeder;

class RequestTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestType::updateOrCreate(
            [
                'id' => 1
            ],
            [
                'type' => 'Hourly',
                'id' => 1
            ]
        );

        RequestType::updateOrCreate(
            [
                'id' => 2
            ],
            [
                'type' => 'Daily',
                'id' => 2
            ]
        );
    }
}
