<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1, // افترض أن هناك مستخدم برقم 1
                'total_amount' => 50.00,
                'status' => 'pending',
            ],
            [
                'user_id' => 2, // افترض أن هناك مستخدم برقم 2
                'total_amount' => 75.00,
                'status' => 'completed',
            ],
            // يمكنك إضافة المزيد من الطلبات هنا حسب الحاجة.
        ]);
    }
}
