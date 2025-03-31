<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'السلوكيات التكراريه او المقيدة',
            'التفاعل الاجتماعي',
            'التواصل اللفظي و الغير لفظي',
            'العناية بالذات',
            ' الانتباه ',
        ];
        foreach ($categories as $category) {
            Category::create([
                'name'=>$category
            ]);
        }
    }
}
