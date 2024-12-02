<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::factory()->create([
            'role_id' => $adminRole->id,
            'name' => 'Admin100',
            'email' => 'admin100@mail.es',
            'password' => bcrypt('admin100'),
        ]);

        User::factory(9)->create(
            ['role_id' => Role::where('name', 'user')->first()->id]
        );


    }
}
