<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PublishingHouse;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookStoreSeeder extends Seeder
{
    public function run()
    {
        // Create 5 Users
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'first_name' => 'User',
                'last_name' => $i,
                'email' => "user{$i}@example.com",
                'phone' => '+1234567890' . $i,
                'password' => bcrypt('password'),
                'role' => 'user',
                'status' => 'active'
            ]);
        }

        // Create some categories first
        $categories = [];
        $categoryNames = [
            ['name_en' => 'Fiction', 'name_fr' => 'Fiction', 'name_ar' => 'خيال'],
            ['name_en' => 'Science', 'name_fr' => 'Science', 'name_ar' => 'علم'],
            ['name_en' => 'History', 'name_fr' => 'Histoire', 'name_ar' => 'تاريخ'],
            ['name_en' => 'Biography', 'name_fr' => 'Biographie', 'name_ar' => 'سيرة ذاتية'],
            ['name_en' => 'Technology', 'name_fr' => 'Technologie', 'name_ar' => 'تكنولوجيا'],
        ];

        foreach ($categoryNames as $categoryData) {
            $categories[] = Category::create([
                'name_en' => $categoryData['name_en'],
                'name_fr' => $categoryData['name_fr'],
                'name_ar' => $categoryData['name_ar'],
                'slug' => Str::slug($categoryData['name_en']),
            ]);
        }

        // Create 5 Publishing Houses (each owned by a user)
        $publishingHouses = [];
        $publishingHouseNames = [
            'Penguin Random House',
            'HarperCollins Publishers',
            'Macmillan Publishers',
            'Simon & Schuster',
            'Hachette Book Group'
        ];

        for ($i = 0; $i < 5; $i++) {
            $publishingHouses[] = PublishingHouse::create([
                'owner_id' => $users[$i]->id,
                'name' => $publishingHouseNames[$i],
                'email' => strtolower(str_replace(' ', '', $publishingHouseNames[$i])) . '@example.com',
                'phone' => '+1987654321' . $i,
                'address' => ($i + 1) . '00 Publishing St, Book City, BC 1000' . $i,
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $publishingHouseNames[$i])) . '.com',
                'established_year' => (1950 + ($i * 10)) . '-01-01', // Convert to date format
                'description' => 'A leading publishing house specializing in various genres and high-quality publications.',
                'social_links' => [
                    'facebook' => 'https://facebook.com/' . strtolower(str_replace(' ', '', $publishingHouseNames[$i])),
                    'twitter' => 'https://twitter.com/' . strtolower(str_replace(' ', '', $publishingHouseNames[$i])),
                    'instagram' => 'https://instagram.com/' . strtolower(str_replace(' ', '', $publishingHouseNames[$i]))
                ],
                'status' => 'active'
            ]);
        }

        // Create 10 Authors (2 authors per publishing house)
        $authors = [];
        $authorNames = [
            'John Smith',
            'Emma Johnson',
            'Michael Brown',
            'Sarah Davis',
            'David Wilson',
            'Lisa Anderson',
            'James Taylor',
            'Maria Garcia',
            'Robert Martinez',
            'Jennifer Lopez'
        ];

        for ($i = 0; $i < 10; $i++) {
            $publishingHouseIndex = $i % 5; // Distribute authors across publishing houses

            $authors[] = Author::create([
                'name' => $authorNames[$i],
                'bio' => 'A renowned author with multiple bestselling books and years of writing experience. Known for engaging storytelling and compelling characters.',
                'publishing_house_id' => $publishingHouses[$publishingHouseIndex]->id,
            ]);
        }

        // Create 10 Books for each Author (100 books total)
        $bookGenres = [
            'Mystery',
            'Romance',
            'Thriller',
            'Adventure',
            'Drama',
            'Comedy',
            'Horror',
            'Fantasy',
            'Sci-Fi',
            'Historical'
        ];

        $bookTitles = [
            'The Silent Observer',
            'Midnight Dreams',
            'Golden Horizon',
            'Whispers in the Dark',
            'The Last Journey',
            'Broken Chains',
            'Rising Sun',
            'Hidden Secrets',
            'Eternal Love',
            'The Final Chapter'
        ];

        foreach ($authors as $authorIndex => $author) {
            for ($bookIndex = 0; $bookIndex < 10; $bookIndex++) {
                $categoryIndex = $bookIndex % count($categories);
                $genre = $bookGenres[$bookIndex];
                $baseTitle = $bookTitles[$bookIndex];

                Book::create([
                    'author_id' => $author->id,
                    'category_id' => $categories[$categoryIndex]->id,
                    'publishing_house_id' => $author->publishing_house_id,
                    'title' => $baseTitle . ' - ' . $genre,
                    'description' => "An engaging {$genre} novel that takes readers on an unforgettable journey. This book combines masterful storytelling with deep character development, making it a must-read for fans of the genre.",
                    'price' => rand(10, 50) + (rand(0, 99) / 100), // Random price between 10.00 and 50.99
                    'language' => ['English', 'French', 'Arabic'][rand(0, 2)],
                    'dimensions' => '6 x 9 inches',
                    'pages_count' => rand(200, 500),
                    'images' => [
                        'book_image_1.jpg',
                        'book_image_2.jpg'
                    ],
                    'cover' => 'book_cover_' . ($authorIndex + 1) . '_' . ($bookIndex + 1) . '.jpg'
                ]);
            }
        }

        $this->command->info('✅ Successfully created:');
        $this->command->info('- 5 Users');
        $this->command->info('- 5 Categories');
        $this->command->info('- 5 Publishing Houses');
        $this->command->info('- 10 Authors (2 per publishing house)');
        $this->command->info('- 100 Books (10 per author)');
        $this->command->info('All relationships properly linked!');
    }
}