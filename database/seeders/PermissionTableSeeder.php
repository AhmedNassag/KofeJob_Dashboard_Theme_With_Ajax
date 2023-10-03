<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',

            'إضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',

            'عرض صلاحية',
            'إضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',

            'الإشعارات',

        ];



        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
