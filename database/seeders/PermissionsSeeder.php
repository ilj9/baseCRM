<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'Super Admin']);

        // All permissions for this app here.
        $permissions = [
            'dashboard.view',

            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            'client.view',
            'client.create',
            'client.update',
            'client.delete',

            'project.view',
            'project.create',
            'project.update',
            'project.delete',

            'task.view',
            'task.create',
            'task.update',
            'task.delete',
            'task.assign',
            'task.complete',

            'address.view',
            'address.create',
            'address.update',
            'address.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $employeePermissions = [
            'dashboard.view',

            'client.view',
            'client.create',
            'client.update',

            'project.view',
            'project.create',
            'project.update',

            'task.view',
            'task.create',
            'task.update',
            'task.assign',
            'task.complete',

            'address.view',
            'address.create',
            'address.update',
        ];

        $employeeRole = Role::create(['name' => 'Employee']);

        foreach ($employeePermissions as $permission) {
            $employeeRole->givePermissionTo($permission);
        }
    }
}
