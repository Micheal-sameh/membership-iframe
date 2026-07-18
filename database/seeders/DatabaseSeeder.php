<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['users.view', 'users.create', 'users.edit'] as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(['users.view', 'users.create', 'users.edit']);

        Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);

        $micheal = User::firstOrCreate(
            ['email' => 'micheal.s.samir@gmail.com'],
            ['name' => 'Micheal Samir', 'password' => Hash::make('Misho$1234')]
        );
        $micheal->assignRole('admin');

        $mina = User::firstOrCreate(
            ['email' => 'fr.mina.mounir@gmail.com'],
            ['name' => 'Fr.Mina Mounir', 'password' => Hash::make('password')]
        );
        $mina->assignRole('member');
    }
}
