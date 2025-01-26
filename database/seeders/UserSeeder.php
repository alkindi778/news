<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // إنشاء حساب المدير
        User::create([
            'name' => 'عبدالسلام التوي',
            'email' => 'noah460@gmail.com',
            'password' => Hash::make('775801243'),
            'is_admin' => true,
        ]);
    }
}
