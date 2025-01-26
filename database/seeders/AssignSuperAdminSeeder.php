<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(2); // المستخدم الحالي
        $role = Role::where('name', 'super-admin')->first();
        
        if ($role && $user) {
            $user->assignRole($role);
            $this->command->info('تم إضافة دور super-admin للمستخدم بنجاح');
        } else {
            $this->command->error('لم يتم العثور على المستخدم أو الدور');
        }
    }
}
