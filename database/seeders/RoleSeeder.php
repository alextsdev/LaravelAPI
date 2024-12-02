<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'user', 'description' => 'Regular User'],
            ['name' => 'editor', 'description' => 'Editor'],
        ];

        foreach($roles as $role) {
            Role::factory()->create($role);
           // Role::create($role);
        }
    }
}
