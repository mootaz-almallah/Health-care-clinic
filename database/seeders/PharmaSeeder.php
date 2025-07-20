<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmaSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'أقراص الأسبرين',
                'description' => 'أقراص مسكنة للألم.',
                'price' => 5.50,
                'quantity' => 100,
                'image' => 'aspirin.jpg',
            ],
            [
                'category_id' => 2,
                'name' => 'مكمل فيتامين سي',
                'description' => 'مكمل غذائي يحتوي على فيتامين سي.',
                'price' => 10.00,
                'quantity' => 200,
                'image' => 'vitamin_c.jpg',
            ],
        ];

        // 1️⃣ Dietary Supplements (m.1.jpg to m.10.jpg)
        for ($i = 1; $i <= 10; $i++) {
            $products[] = [
                'category_id' => 2,
                'name' => "Supplement Capsule $i",
                'description' => "High-quality dietary supplement to boost immunity and energy. Formula $i.",
                'price' => rand(10, 30),
                'quantity' => rand(20, 100),
                'image' => "m.$i.jpg",
            ];
        }

        // 2️⃣ Blood Pressure Medicines (d.1.jpg to d.10.jpg)
        for ($i = 1; $i <= 10; $i++) {
            $products[] = [
                'category_id' => 3,
                'name' => "BP Control Tablet $i",
                'description' => "Effective medication for controlling high blood pressure. Type $i.",
                'price' => rand(15, 45),
                'quantity' => rand(10, 80),
                'image' => "d.$i.jpg",
            ];
        }

        // 3️⃣ Diabetes Medicines (s.1.jpg to s.10.jpg)
        for ($i = 1; $i <= 10; $i++) {
            $products[] = [
                'category_id' => 4,
                'name' => "Diabetes Care Pill $i",
                'description' => "Helps regulate blood sugar and supports insulin function. Series $i.",
                'price' => rand(12, 35),
                'quantity' => rand(15, 60),
                'image' => "s.$i.jpg",
            ];
        }

        // 4️⃣ Heart Medicines (g.1.jpg to g.10.jpg)
        for ($i = 1; $i <= 10; $i++) {
            $products[] = [
                'category_id' => 5,
                'name' => "Heart Health Med $i",
                'description' => "Supports cardiovascular health and improves heart function. Version $i.",
                'price' => rand(20, 60),
                'quantity' => rand(10, 50),
                'image' => "g.$i.jpg",
            ];
        }

        // إدخال جميع المنتجات إلى الجدول
        DB::table('pharma')->insert($products);
    }
}
