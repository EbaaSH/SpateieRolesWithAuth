<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',

            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Roles
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        // Admin gets all permissions
        $adminRole->givePermissionTo(Permission::all());

        // User gets limited permissions
        $userRole->givePermissionTo([
            'view posts',
            'create posts',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Test Users
        |--------------------------------------------------------------------------
        */

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);

        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Roles to Users
        |--------------------------------------------------------------------------
        */

        $admin->assignRole('admin');
        $user->assignRole('user');

    }
}
