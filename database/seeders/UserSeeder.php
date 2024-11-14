<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::query()->truncate();

        User::factory(10)->create([
            'role' => 'buyer',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'phone' => '089123456789',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);
    }
}
