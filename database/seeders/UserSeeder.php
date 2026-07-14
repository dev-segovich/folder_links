<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'segovich'],
            [
                'name' => 'Jesús',
                'email' => 'jesus@kernel.local',
                'password' => Hash::make('Mecos0500'),
                'role' => 'dev',
            ]
        );

        User::firstOrCreate(
            ['username' => 'mcoello'],
            [
                'name' => 'Miguel Ángel',
                'email' => 'miguel@kernel.local',
                'password' => Hash::make('Mecos0500'),
                'role' => 'dev',
            ]
        );

        User::firstOrCreate(
            ['username' => 'jlozano'],
            [
                'name' => 'José',
                'email' => 'josé@kernel.local',
                'password' => Hash::make('Mecos0500'),
                'role' => 'dev',
            ]
        );

        $this->command->info('Default users created.');
    }
}
