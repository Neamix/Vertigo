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
                'name' => "View User",
                'parent' => 'User Priviledges'
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 2
            ],
            [
                'name' => "Update/Create User",
                'parent' => 'User Priviledges',
                'parent_id' => 1
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 3
            ],
            [
                'name' => 'Delete User',
                'parent' => 'User Priviledges',
                'parent_id' => 1
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 4
            ],
            [
                'name' => 'View Status',
                'parent' => 'Status Priviledges',
            ]
        );


        Priviledge::updateOrCreate(
            [
                'id' => 5
            ],
            [
                'name' => 'Upsert Status',
                'parent' => 'Status Priviledges',
                'parent_id' => 4
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 6
            ],
            [
                'name' => 'Delete Status',
                'parent' => 'Status Priviledges',
                'parent_id' => 4
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 7
            ],
            [
                'name' => 'View Request',
                'parent' => 'Request Priviledges',
            ]
        );


        Priviledge::updateOrCreate(
            [
                'id' => 8
            ],
            [
                'name' => 'Upsert Request',
                'parent' => 'Request Priviledges',
                'parent_id' => 7
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 9
            ],
            [
                'name' => 'Upsert Delete',
                'parent' => 'Request Priviledges',
                'parent_id' => 7
            ]
        );

        

        Priviledge::updateOrCreate(
            [
                'id' => 10
            ],
            [
                'name' => 'View Role',
                'parent' => 'Role Priviledges'
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 11
            ],
            [
                'name' => 'Update/Create Role',
                'parent' => 'Role Priviledges',
                'parent_id' => 10
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 12
            ],
            [
                'name' => 'Delete Role',
                'parent' => 'Role Priviledges',
                'parent_id' => 10
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 13
            ],
            [
                'name' => 'View Attending',
                'parent' => 'Attending Priviledges',
            ]
        );

        Priviledge::updateOrCreate(
            [
                'id' => 14
            ],
            [
                'name' => 'Update/Create Attending',
                'parent' => 'Attending Priviledges',
                'parent_id' => 13
            ]
        );
        
        Priviledge::updateOrCreate(
            [
                'id' => 15
            ],
            [
                'name' => 'Delete Attending',
                'parent' => 'Attending Priviledges',
                'parent_id' => 13
            ]
        );

    }
}
