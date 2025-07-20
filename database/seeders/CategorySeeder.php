<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // مسح البيانات السابقة
        DB::table('categories')->truncate();  // هذه تقوم بحذف جميع البيانات السابقة

        // إدخال بيانات جديدة مع تجنب التكرار
        DB::table('categories')->insertOrIgnore([
            [
                'name' => 'أدوية',
                'slug' => 'adweya',
                'description' => 'أدوية لعلاج الأمراض المختلفة.',
            ],
            [
                'name' => 'مكملات غذائية',
                'slug' => 'mukamalat-ghitha',
                'description' => 'مكملات غذائية لدعم الصحة العامة.',
            ],
            // يمكنك إضافة المزيد من الفئات هنا حسب الحاجة.
        ]);
    }
}
