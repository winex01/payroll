<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     *
     */
    protected $rolesAndPermissions = [

        'users' => [
            'users_list',
            'users_create',
            'billings_show',
            'users_update',
            'users_delete',
            'users_revise',
        ],

        'roles' => [
            'roles_list',
            'roles_create',
            'roles_update',
            'roles_delete',
            'roles_revise',
        ],

        'permissions' => [
            'permissions_list',
            'permissions_create',
            'permissions_update',
            'permissions_delete',
            'permissions_revise',
        ],

        'menus' => [
            'menus_list',
            'menus_create',
            'menus_show',
            'menus_update',
            'menus_delete',
            'menus_reorder',
            'menus_revise',
        ],

        'employees' => [
            'employees_list',
            'employees_create',
            'employees_show',
            'employees_update',
            'employees_delete',
            'employees_filters',
            'employees_revise',
        ],

        'families' => [
            'families_list',
            'families_create',
            'families_show',
            'families_update',
            'families_delete',
            'families_filters',
            'families_revise',
        ],

        'companies' => [
            'companies_list',
            'companies_create',
            'companies_show',
            'companies_update',
            'companies_delete',
            'companies_revise',
        ],

        'departments' => [
            'departments_list',
            'departments_create',
            'departments_update',
            'departments_delete',
            'departments_revise',
        ],

        'employment_details' => [
            'employment_details_list',
            'employment_details_create',
            'employment_details_show',
            'employment_details_update',
            'employment_details_delete',
            'employment_details_new_hire',
            'employment_details_filters',
            'employment_details_revise',
            'employment_details_backdating',
        ],

        'employment_detail_types' => [
            'employment_detail_types_list',
            'employment_detail_types_create',
            'employment_detail_types_update',
            'employment_detail_types_delete',
            'employment_detail_types_reorder',
            'employment_detail_types_revise',
        ],

        'payroll_groups' => [
            'payroll_groups_list',
            'payroll_groups_create',
            'payroll_groups_update',
            'payroll_groups_delete',
            'payroll_groups_revise',
        ],

        'shift_schedules' => [
            'shift_schedules_list',
            'shift_schedules_create',
            'shift_schedules_show',
            'shift_schedules_update',
            'shift_schedules_delete',
            'shift_schedules_revise',
        ],

        'employee_shift_schedules' => [
            'employee_shift_schedules_list',
            'employee_shift_schedules_create',
            'employee_shift_schedules_show',
            'employee_shift_schedules_update',
            'employee_shift_schedules_delete',
            'employee_shift_schedules_filters',
            'employee_shift_schedules_revise',
            'employee_shift_schedules_backdating',
        ],

        'employee_calendars' => [
            'employee_calendars_list',
            'employee_calendars_show',
            'employee_calendars_filters',
            'employee_calendars_click_and_select',
            'employee_calendars_backdating',
        ],

        'change_shift_schedules' => [
            'change_shift_schedules_list',
            'change_shift_schedules_create',
            'change_shift_schedules_show',
            'change_shift_schedules_update',
            'change_shift_schedules_delete',
            'change_shift_schedules_filters',
            'change_shift_schedules_revise',
            'change_shift_schedules_backdating',
        ],

        'leave_types' => [
            'leave_types_list',
            'leave_types_create',
            'leave_types_show',
            'leave_types_update',
            'leave_types_delete',
            'leave_types_filters',
            'leave_types_revise',
        ],

        'relationships' => [
            'relationships_list',
            'relationships_create',
            'relationships_update',
            'relationships_delete',
            'relationships_revise',
        ],

        'beneficiaries' => [
            'beneficiaries_list',
            'beneficiaries_create',
            'beneficiaries_show',
            'beneficiaries_update',
            'beneficiaries_delete',
            'beneficiaries_filters',
            'beneficiaries_revise',
        ],
    ];

    /**
     * if backpack config is null
     * then default is web
     */
    public $guardName;

    /**
     *
     */
    public function __construct()
    {
        $this->guardName = config('backpack.base.guard') ?? 'web';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create specific permissions
        $this->createRolesAndPermissions();

        // assign all roles define in config/seeder to admin
        $this->assignAllRolesToAdmin();

    }

    private function assignAllRolesToAdmin()
    {
        // super admin ID = 1
        $admin = User::findOrFail(1);

        $roles = collect($this->rolesAndPermissions)->keys()->unique()->toArray();
        $roles = array_diff($roles, $this->dontAssignRoles());
        $admin->syncRoles($roles);
    }

    private function createRolesAndPermissions()
    {
        foreach ($this->rolesAndPermissions as $role => $permissions) {
            // create role
            $roleInstance = config('permission.models.role')::firstOrCreate([
                'name' => $role,
                'guard_name' => $this->guardName,
            ]);

            foreach ($permissions as $rolePermission) {
                $permission = config('permission.models.permission')::firstOrCreate([
                    'name' => $rolePermission,
                    'guard_name' => $this->guardName,
                ]);

                if (
                    !Str::endsWith($rolePermission, [
                        '_backdating',
                        // '_revise'
                    ])
                ) {
                    // assign role_permission to role
                    $permission->assignRole($role);
                }

                // $permission->assignRole($role);
            }
        }

    }

    private function dontAssignRoles()
    {
        return [
            //
        ];
    }
}
