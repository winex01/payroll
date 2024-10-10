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
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
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
            array (
                'id' => 2,
                'label' => 'Menus',
                'icon' => 'la la-list',
                'url' => 'menu',
                'permissions' => '["menus_list"]',
                'parent_id' => 8,
                'lft' => 33,
                'rgt' => 34,
                'depth' => 2,
                'created_at' => '2024-09-24 19:08:21',
                'updated_at' => '2024-09-24 19:08:21',
            ),
            2 => 
            array (
                'id' => 3,
                'label' => 'Authentication',
                'icon' => NULL,
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => 8,
                'lft' => 23,
                'rgt' => 24,
                'depth' => 2,
                'created_at' => '2024-09-24 19:08:43',
                'updated_at' => '2024-09-24 19:08:43',
            ),
            3 => 
            array (
                'id' => 4,
                'label' => 'Users',
                'icon' => 'la la-user',
                'url' => 'user',
                'permissions' => '["users_list"]',
                'parent_id' => 8,
                'lft' => 25,
                'rgt' => 26,
                'depth' => 2,
                'created_at' => '2024-09-24 19:09:26',
                'updated_at' => '2024-09-24 19:09:26',
            ),
            4 => 
            array (
                'id' => 5,
                'label' => 'Roles',
                'icon' => 'la la-group',
                'url' => 'role',
                'permissions' => '["roles_list"]',
                'parent_id' => 8,
                'lft' => 27,
                'rgt' => 28,
                'depth' => 2,
                'created_at' => '2024-09-24 19:09:48',
                'updated_at' => '2024-09-24 19:09:48',
            ),
            5 => 
            array (
                'id' => 6,
                'label' => 'Permissions',
                'icon' => 'la la-key',
                'url' => 'permission',
                'permissions' => '["permissions_list"]',
                'parent_id' => 8,
                'lft' => 29,
                'rgt' => 30,
                'depth' => 2,
                'created_at' => '2024-09-24 19:10:10',
                'updated_at' => '2024-09-24 19:10:10',
            ),
            6 => 
            array (
                'id' => 7,
                'label' => 'Tools',
                'icon' => NULL,
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => 8,
                'lft' => 31,
                'rgt' => 32,
                'depth' => 2,
                'created_at' => '2024-09-24 19:10:16',
                'updated_at' => '2024-09-24 19:10:16',
            ),
            7 => 
            array (
                'id' => 8,
                'label' => 'Add-ons',
                'icon' => 'la la-puzzle-piece',
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => NULL,
                'lft' => 22,
                'rgt' => 35,
                'depth' => 1,
                'created_at' => '2024-09-24 19:11:22',
                'updated_at' => '2024-09-24 19:11:22',
            ),
            8 => 
            array (
                'id' => 9,
                'label' => 'Employees',
                'icon' => 'la la-user-plus',
                'url' => 'employee',
                'permissions' => '["employees_list"]',
                'parent_id' => 11,
                'lft' => 5,
                'rgt' => 6,
                'depth' => 2,
                'created_at' => '2024-09-27 14:24:01',
                'updated_at' => '2024-09-27 14:24:18',
            ),
            9 => 
            array (
                'id' => 10,
                'label' => 'Family Data',
                'icon' => 'las la-clone',
                'url' => 'family',
                'permissions' => '["families_list"]',
                'parent_id' => 11,
                'lft' => 7,
                'rgt' => 8,
                'depth' => 2,
                'created_at' => '2024-09-29 15:26:53',
                'updated_at' => '2024-10-09 13:55:14',
            ),
            10 => 
            array (
                'id' => 11,
                'label' => '201 Files',
                'icon' => 'las la-archive',
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 9,
                'depth' => 1,
                'created_at' => '2024-10-07 12:39:04',
                'updated_at' => '2024-10-07 12:39:04',
            ),
            11 => 
            array (
                'id' => 12,
                'label' => 'Companies',
                'icon' => 'las la-building',
                'url' => 'company',
                'permissions' => '["companies_list"]',
                'parent_id' => 13,
                'lft' => 13,
                'rgt' => 14,
                'depth' => 2,
                'created_at' => '2024-10-09 13:12:27',
                'updated_at' => '2024-10-10 14:50:05',
            ),
            12 => 
            array (
                'id' => 13,
                'label' => 'Settings',
                'icon' => 'las la-cog',
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => NULL,
                'lft' => 10,
                'rgt' => 21,
                'depth' => 1,
                'created_at' => '2024-10-09 13:13:30',
                'updated_at' => '2024-10-09 13:13:30',
            ),
            13 => 
            array (
                'id' => 14,
                'label' => 'Locations',
                'icon' => 'las la-map-marked-alt',
                'url' => 'location',
                'permissions' => '["locations_list"]',
                'parent_id' => 13,
                'lft' => 19,
                'rgt' => 20,
                'depth' => 2,
                'created_at' => '2024-10-10 13:55:39',
                'updated_at' => '2024-10-10 13:55:39',
            ),
            14 => 
            array (
                'id' => 15,
                'label' => '201 Files',
                'icon' => NULL,
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => 13,
                'lft' => 11,
                'rgt' => 12,
                'depth' => 2,
                'created_at' => '2024-10-10 14:19:46',
                'updated_at' => '2024-10-10 14:22:39',
            ),
            15 => 
            array (
                'id' => 16,
                'label' => 'Departments',
                'icon' => 'las la-layer-group',
                'url' => 'department',
                'permissions' => '["departments_list"]',
                'parent_id' => 13,
                'lft' => 15,
                'rgt' => 16,
                'depth' => 2,
                'created_at' => '2024-10-10 14:49:27',
                'updated_at' => '2024-10-10 14:49:27',
            ),
            16 => 
            array (
                'id' => 17,
                'label' => 'Divisions',
                'icon' => 'las la-star-half-alt',
                'url' => 'division',
                'permissions' => '["divisions_list"]',
                'parent_id' => 13,
                'lft' => 17,
                'rgt' => 18,
                'depth' => 2,
                'created_at' => '2024-10-10 18:39:03',
                'updated_at' => '2024-10-10 18:39:03',
            ),
        ));
        
        
    }
}