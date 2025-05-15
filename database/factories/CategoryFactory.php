<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        // Predefined 40 book categories with translations
        $categories = [
            ['en' => 'Fiction', 'fr' => 'Fiction', 'ar' => 'خيال'],
            ['en' => 'Non-Fiction', 'fr' => 'Non-fiction', 'ar' => 'غير خيالي'],
            ['en' => 'Science Fiction', 'fr' => 'Science-fiction', 'ar' => 'خيال علمي'],
            ['en' => 'Fantasy', 'fr' => 'Fantaisie', 'ar' => 'فانتازيا'],
            ['en' => 'Mystery', 'fr' => 'Mystère', 'ar' => 'غموض'],
            ['en' => 'Romance', 'fr' => 'Romance', 'ar' => 'رومانسية'],
            ['en' => 'Thriller', 'fr' => 'Thriller', 'ar' => 'إثارة'],
            ['en' => 'Biography', 'fr' => 'Biographie', 'ar' => 'سيرة ذاتية'],
            ['en' => 'History', 'fr' => 'Histoire', 'ar' => 'تاريخ'],
            ['en' => 'Self-Help', 'fr' => 'Développement personnel', 'ar' => 'تطوير الذات'],
            ['en' => 'Adventure', 'fr' => 'Aventure', 'ar' => 'مغامرة'],
            ['en' => 'Horror', 'fr' => 'Horreur', 'ar' => 'رعب'],
            ['en' => 'Poetry', 'fr' => 'Poésie', 'ar' => 'شعر'],
            ['en' => 'Crime', 'fr' => 'Crime', 'ar' => 'جريمة'],
            ['en' => 'Drama', 'fr' => 'Drame', 'ar' => 'دراما'],
            ['en' => 'Historical Fiction', 'fr' => 'Fiction historique', 'ar' => 'خيال تاريخي'],
            ['en' => 'Memoir', 'fr' => 'Mémoires', 'ar' => 'مذكرات'],
            ['en' => 'Cookbooks', 'fr' => 'Livres de cuisine', 'ar' => 'كتب الطبخ'],
            ['en' => 'Travel', 'fr' => 'Voyage', 'ar' => 'سفر'],
            ['en' => 'Science', 'fr' => 'Science', 'ar' => 'علم'],
            ['en' => 'Technology', 'fr' => 'Technologie', 'ar' => 'تكنولوجيا'],
            ['en' => 'Business', 'fr' => 'Affaires', 'ar' => 'أعمال'],
            ['en' => 'Economics', 'fr' => 'Économie', 'ar' => 'اقتصاد'],
            ['en' => 'Philosophy', 'fr' => 'Philosophie', 'ar' => 'فلسفة'],
            ['en' => 'Psychology', 'fr' => 'Psychologie', 'ar' => 'علم النفس'],
            ['en' => 'Sociology', 'fr' => 'Sociologie', 'ar' => 'علم الاجتماع'],
            ['en' => 'Politics', 'fr' => 'Politique', 'ar' => 'سياسة'],
            ['en' => 'Religion', 'fr' => 'Religion', 'ar' => 'دين'],
            ['en' => 'Spirituality', 'fr' => 'Spiritualité', 'ar' => 'روحانيات'],
            ['en' => 'Art', 'fr' => 'Art', 'ar' => 'فن'],
            ['en' => 'Photography', 'fr' => 'Photographie', 'ar' => 'تصوير فوتوغرافي'],
            ['en' => 'Music', 'fr' => 'Musique', 'ar' => 'موسيقى'],
            ['en' => 'Sports', 'fr' => 'Sports', 'ar' => 'رياضة'],
            ['en' => 'Health', 'fr' => 'Santé', 'ar' => 'صحة'],
            ['en' => 'Fitness', 'fr' => 'Fitness', 'ar' => 'لياقة بدنية'],
            ['en' => 'Parenting', 'fr' => 'Parenting', 'ar' => 'تربية الأطفال'],
            ['en' => 'Education', 'fr' => 'Éducation', 'ar' => 'تعليم'],
            ['en' => 'Nature', 'fr' => 'Nature', 'ar' => 'طبيعة'],
            ['en' => 'Gardening', 'fr' => 'Jardinage', 'ar' => 'بستنة'],
            ['en' => 'Crafts', 'fr' => 'Artisanat', 'ar' => 'حرف يدوية']
        ];

        // Ensure unique category selection
        static $usedCategories = [];
        $category = $this->faker->unique()->randomElement($categories);

        // Reset used categories if all have been used
        if (count($usedCategories) === count($categories)) {
            $this->faker->unique(true); // Reset unique modifier
            $usedCategories = [];
        }

        $usedCategories[] = $category['en'];

        return [
            'id' => Str::uuid()->toString(),
            'name_en' => $category['en'],
            'name_fr' => $category['fr'],
            'name_ar' => $category['ar'],
            'slug' => Str::slug($category['en']),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }
}