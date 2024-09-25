<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('menus')->delete();

        \DB::table('menus')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'label' => 'Dashboard',
                    'icon' => 'la la-home nav-icon',
                    'url' => 'dashboard',
                    'permissions' => NULL,
                    'parent_id' => NULL,
                    'lft' => 2,
                    'rgt' => 3,
                    'depth' => 1,
                    'created_at' => '2024-09-24 19:07:57',
                    'updated_at' => '2024-09-24 19:07:57',
                ),
            1 =>
                array(
                    'id' => 2,
                    'label' => 'Menus',
                    'icon' => 'la la-list',
                    'url' => 'menu',
                    'permissions' => '["menus_list"]',
                    'parent_id' => 8,
                    'lft' => 15,
                    'rgt' => 16,
                    'depth' => 2,
                    'created_at' => '2024-09-24 19:08:21',
                    'updated_at' => '2024-09-24 19:08:21',
                ),
            2 =>
                array(
                    'id' => 3,
                    'label' => 'Authentication',
                    'icon' => NULL,
                    'url' => NULL,
                    'permissions' => NULL,
                    'parent_id' => 8,
                    'lft' => 5,
                    'rgt' => 6,
                    'depth' => 2,
                    'created_at' => '2024-09-24 19:08:43',
                    'updated_at' => '2024-09-24 19:08:43',
                ),
            3 =>
                array(
                    'id' => 4,
                    'label' => 'Users',
                    'icon' => 'la la-user',
                    'url' => 'user',
                    'permissions' => '["users_list"]',
                    'parent_id' => 8,
                    'lft' => 7,
                    'rgt' => 8,
                    'depth' => 2,
                    'created_at' => '2024-09-24 19:09:26',
                    'updated_at' => '2024-09-24 19:09:26',
                ),
            4 =>
                array(
                    'id' => 5,
                    'label' => 'Roles',
                    'icon' => 'la la-group',
                    'url' => 'role',
                    'permissions' => '["roles_list"]',
                    'parent_id' => 8,
                    'lft' => 9,
                    'rgt' => 10,
                    'depth' => 2,
                    'created_at' => '2024-09-24 19:09:48',
                    'updated_at' => '2024-09-24 19:09:48',
                ),
            5 =>
                array(
                    'id' => 6,
                    'label' => 'Permissions',
                    'icon' => 'la la-key',
                    'url' => 'permission',
                    'permissions' => '["permissions_list"]',
                    'parent_id' => 8,
                    'lft' => 11,
                    'rgt' => 12,
                    'depth' => 2,
                    'created_at' => '2024-09-24 19:10:10',
                    'updated_at' => '2024-09-24 19:10:10',
                ),
            6 =>
                array(
                    'id' => 7,
                    'label' => 'Tools',
                    'icon' => NULL,
                    'url' => NULL,
                    'permissions' => NULL,
                    'parent_id' => 8,
                    'lft' => 13,
                    'rgt' => 14,
                    'depth' => 2,
                    'created_at' => '2024-09-24 19:10:16',
                    'updated_at' => '2024-09-24 19:10:16',
                ),
            7 =>
                array(
                    'id' => 8,
                    'label' => 'Add-ons',
                    'icon' => 'la la-puzzle-piece',
                    'url' => NULL,
                    'permissions' => NULL,
                    'parent_id' => NULL,
                    'lft' => 4,
                    'rgt' => 17,
                    'depth' => 1,
                    'created_at' => '2024-09-24 19:11:22',
                    'updated_at' => '2024-09-24 19:11:22',
                ),
        ));


    }
}
