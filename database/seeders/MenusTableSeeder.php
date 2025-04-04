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
                'lft' => 53,
                'rgt' => 54,
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
                'lft' => 43,
                'rgt' => 44,
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
                'lft' => 45,
                'rgt' => 46,
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
                'lft' => 47,
                'rgt' => 48,
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
                'lft' => 49,
                'rgt' => 50,
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
                'lft' => 51,
                'rgt' => 52,
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
                'lft' => 42,
                'rgt' => 55,
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
                'lft' => 11,
                'rgt' => 12,
                'depth' => 2,
                'created_at' => '2024-09-29 15:26:53',
                'updated_at' => '2024-10-09 13:55:14',
            ),
            10 => 
            array (
                'id' => 11,
                'label' => 'Employee Records',
                'icon' => 'las la-archive',
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 13,
                'depth' => 1,
                'created_at' => '2024-10-07 12:39:04',
                'updated_at' => '2025-02-26 13:20:13',
            ),
            11 => 
            array (
                'id' => 12,
                'label' => 'Companies',
                'icon' => 'las la-building',
                'url' => 'company',
                'permissions' => '["companies_list"]',
                'parent_id' => 13,
                'lft' => 29,
                'rgt' => 30,
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
                'lft' => 26,
                'rgt' => 41,
                'depth' => 1,
                'created_at' => '2024-10-09 13:13:30',
                'updated_at' => '2024-10-09 13:13:30',
            ),
            13 => 
            array (
                'id' => 15,
                'label' => 'Employee Records',
                'icon' => NULL,
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => 13,
                'lft' => 27,
                'rgt' => 28,
                'depth' => 2,
                'created_at' => '2024-10-10 14:19:46',
                'updated_at' => '2025-02-26 13:20:19',
            ),
            14 => 
            array (
                'id' => 16,
                'label' => 'Departments',
                'icon' => 'las la-layer-group',
                'url' => 'department',
                'permissions' => '["departments_list"]',
                'parent_id' => 13,
                'lft' => 31,
                'rgt' => 32,
                'depth' => 2,
                'created_at' => '2024-10-10 14:49:27',
                'updated_at' => '2024-10-10 14:49:27',
            ),
            15 => 
            array (
                'id' => 17,
                'label' => 'Employment Details',
                'icon' => 'las la-address-book',
                'url' => 'employment-detail',
                'permissions' => '["employment_details_list"]',
                'parent_id' => 11,
                'lft' => 7,
                'rgt' => 8,
                'depth' => 2,
                'created_at' => '2024-10-17 17:51:19',
                'updated_at' => '2024-10-17 17:51:19',
            ),
            16 => 
            array (
                'id' => 18,
                'label' => 'Employment Detail Types',
                'icon' => 'las la-list-ol',
                'url' => 'employment-detail-type',
                'permissions' => '["employment_detail_types_list"]',
                'parent_id' => 13,
                'lft' => 33,
                'rgt' => 34,
                'depth' => 2,
                'created_at' => '2024-10-17 19:39:34',
                'updated_at' => '2024-10-17 19:39:34',
            ),
            17 => 
            array (
                'id' => 19,
                'label' => 'Payroll Groups',
                'icon' => 'las la-vector-square',
                'url' => 'payroll-group',
                'permissions' => '["payroll_groups_list"]',
                'parent_id' => 13,
                'lft' => 39,
                'rgt' => 40,
                'depth' => 2,
                'created_at' => '2024-10-26 16:13:53',
                'updated_at' => '2024-10-26 16:13:53',
            ),
            18 => 
            array (
                'id' => 20,
                'label' => 'Payrolls',
                'icon' => NULL,
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => 13,
                'lft' => 37,
                'rgt' => 38,
                'depth' => 2,
                'created_at' => '2024-10-26 16:14:40',
                'updated_at' => '2024-10-26 16:14:40',
            ),
            19 => 
            array (
                'id' => 21,
                'label' => 'Shift Schedules',
                'icon' => 'las la-calendar',
                'url' => 'shift-schedule',
                'permissions' => '["shift_schedules_list"]',
                'parent_id' => 22,
                'lft' => 23,
                'rgt' => 24,
                'depth' => 2,
                'created_at' => '2024-12-02 14:02:48',
                'updated_at' => '2024-12-02 14:02:48',
            ),
            20 => 
            array (
                'id' => 22,
                'label' => 'DTR and Shifts',
                'icon' => 'las la-hourglass-half',
                'url' => NULL,
                'permissions' => NULL,
                'parent_id' => NULL,
                'lft' => 14,
                'rgt' => 25,
                'depth' => 1,
                'created_at' => '2024-12-02 14:03:56',
                'updated_at' => '2025-02-26 13:24:47',
            ),
            21 => 
            array (
                'id' => 23,
                'label' => 'Employee Shifts',
                'icon' => 'las la-business-time',
                'url' => 'employee-shift-schedule',
                'permissions' => '["employee_shift_schedules_list"]',
                'parent_id' => 22,
                'lft' => 19,
                'rgt' => 20,
                'depth' => 2,
                'created_at' => '2025-02-26 12:58:11',
                'updated_at' => '2025-03-19 08:33:03',
            ),
            22 => 
            array (
                'id' => 24,
                'label' => 'Employee Calendars',
                'icon' => 'las la-calendar',
                'url' => 'employee-calendar',
                'permissions' => '["employee_calendars_list"]',
                'parent_id' => 22,
                'lft' => 15,
                'rgt' => 16,
                'depth' => 2,
                'created_at' => '2025-03-11 10:27:17',
                'updated_at' => '2025-03-11 11:06:27',
            ),
            23 => 
            array (
                'id' => 25,
                'label' => 'Change Shifts',
                'icon' => 'las la-calendar-check',
                'url' => 'change-shift-schedule',
                'permissions' => '["change_shift_schedules_list"]',
                'parent_id' => 22,
                'lft' => 17,
                'rgt' => 18,
                'depth' => 2,
                'created_at' => '2025-03-18 19:34:28',
                'updated_at' => '2025-03-24 19:45:04',
            ),
            24 => 
            array (
                'id' => 26,
                'label' => 'Leave Types',
                'icon' => 'las la-shapes',
                'url' => 'leave-type',
                'permissions' => '["leave_types_list"]',
                'parent_id' => 22,
                'lft' => 21,
                'rgt' => 22,
                'depth' => 2,
                'created_at' => '2025-03-24 19:35:59',
                'updated_at' => '2025-03-24 19:56:34',
            ),
            25 => 
            array (
                'id' => 27,
                'label' => 'Relationships',
                'icon' => 'la la-question',
                'url' => 'relationship',
                'permissions' => '["relationships_list"]',
                'parent_id' => 13,
                'lft' => 35,
                'rgt' => 36,
                'depth' => 2,
                'created_at' => '2025-03-29 21:42:39',
                'updated_at' => '2025-03-29 22:13:59',
            ),
            26 => 
            array (
                'id' => 28,
                'label' => 'Beneficiaries',
                'icon' => 'la la-question',
                'url' => 'beneficiary',
                'permissions' => '["beneficiaries_list"]',
                'parent_id' => 11,
                'lft' => 9,
                'rgt' => 10,
                'depth' => 2,
                'created_at' => '2025-03-30 19:51:22',
                'updated_at' => '2025-03-30 19:51:22',
            ),
        ));
        
        
    }
}