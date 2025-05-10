<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['en' => 'Fiction',     'fr' => 'Fiction',     'ar' => 'خيال'],
            ['en' => 'Non-fiction', 'fr' => 'Non-fiction', 'ar' => 'غير خيالي'],
            ['en' => 'Science',     'fr' => 'Science',     'ar' => 'علم'],
            ['en' => 'History',     'fr' => 'Histoire',    'ar' => 'تاريخ'],
            ['en' => 'Biography',   'fr' => 'Biographie',  'ar' => 'سيرة ذاتية'],
            ['en' => 'Children',    'fr' => 'Enfants',     'ar' => 'أطفال'],
            ['en' => 'Technology',  'fr' => 'Technologie', 'ar' => 'تكنولوجيا'],
            ['en' => 'Art',         'fr' => 'Art',         'ar' => 'فن'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name_en' => $cat['en'],
                'name_fr' => $cat['fr'],
                'name_ar' => $cat['ar'],
                'slug' => Str::slug($cat['en']),
            ]);
        }
    }
}
