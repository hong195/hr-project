<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    protected $permissions = ['view', 'Pharmacy', 'update'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->createSubscriber();
    }

    private function createAdmin()
    {
        $admin = $this->createUser([
            'first_name' => 'admin',
            'last_name' => 'admin2',
            'patronymic' => 'admin3',
            'email' => 'admin@gmail.com',
            'password' => 'qwerty123'
        ]);

        $adminRole = Role::create(['name' => 'Admin'])
            ->syncPermissions($this->createPermissions());

        $admin->assignRole($adminRole);
    }

    private function createSubscriber()
    {
        $userRole = Role::create(['name' => 'Subscriber']);

        $user = $this->createUser([
            'first_name' => 'user',
            'last_name' => 'user2',
            'patronymic' => 'user3',
            'email' => 'user@gmail.com',
            'password' => 'qwerty123'
        ]);

        $userRole->givePermissionTo($this->createPermissions()->first());

        $user->assignRole($userRole);
    }

    private function createPermissions()
    {
        if ($this->permissions instanceof Collection) {
            return $this->permissions;
        }

        return $this->permissions = collect($this->permissions)->map(function ($name) {
            return \Spatie\Permission\Models\Permission::create(['name' => $name]);
        });
    }

    private function createUser(array $userData)
    {
        return \App\Models\User::factory()->create($userData);
    }
}
