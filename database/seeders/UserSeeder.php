<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@kharismasuksespersada.co.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'is_active' => true,
            ],
            [
                'name' => 'Sales Staff',
                'email' => 'sales@kharismasuksespersada.co.id',
                'password' => bcrypt('password123'),
                'role' => 'sales',
                'phone' => '081234567891',
                'is_active' => true,
            ],
            [
                'name' => 'Admin Gudang',
                'email' => 'gudang@kharismasuksespersada.co.id',
                'password' => bcrypt('password123'),
                'role' => 'admin_gudang',
                'phone' => '081234567892',
                'is_active' => true,
            ],
            [
                'name' => 'Finance Staff',
                'email' => 'finance@kharismasuksespersada.co.id',
                'password' => bcrypt('password123'),
                'role' => 'finance',
                'phone' => '081234567893',
                'is_active' => true,
            ],
            [
                'name' => 'Customer Demo',
                'email' => 'customer@example.com',
                'password' => bcrypt('password123'),
                'role' => 'customer',
                'phone' => '081234567894',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'phone' => $userData['phone'],
                    'is_active' => $userData['is_active'],
                ]
            );
            
            $user->assignRole($userData['role']);
        }
    }
}
