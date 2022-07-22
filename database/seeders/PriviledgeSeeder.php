<?php

namespace Database\Seeders;

use App\Models\Priviledge;
use Illuminate\Database\Seeder;

class PriviledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User Priviledges
        Priviledge::updateOrCreate(
            [
                'id' => 1
            ],
            [
                'name' => 'Edit User',
                'parent' => 'User Priviledges'
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 2
            ],
            [
                'name' => "Update User",
                'parent' => 'User Priviledges'
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 3
            ],
            [
                'name' => 'Delete User',
                'parent' => 'User Priviledges'
            ]
        );
    }
}
