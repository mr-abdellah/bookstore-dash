<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PublishingHouse;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\PlatformSettings;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookStoreSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '+12345678901',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active'
        ]);

        // Create Clients
        $clients = [];
        for ($i = 1; $i <= 4; $i++) {
            $clients[] = User::create([
                'first_name' => 'Client',
                'last_name' => $i,
                'email' => "client{$i}@example.com",
                'phone' => '+1234567890' . $i,
                'password' => bcrypt('password'),
                'role' => 'client',
                'status' => 'active'
            ]);
        }

        // Create Publishing House Owners
        $owners = [];
        for ($i = 1; $i <= 5; $i++) {
            $owners[] = User::create([
                'first_name' => 'Owner',
                'last_name' => $i,
                'email' => "owner{$i}@example.com",
                'phone' => '+1987654321' . $i,
                'password' => bcrypt('password'),
                'role' => 'publishing_house_owner',
                'status' => 'active'
            ]);
        }

        // Seed Platform Settings (for global profit percentage)
        PlatformSettings::create([
            'profit_percentage' => 2.00, // 2% default commission rate
            'platform_name' => 'Book Platform',
            'contact_email' => 'contact@example.com',
            'contact_phone' => '+1234567890',
        ]);

        // Create Categories
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

        // Create Publishing Houses
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
                'owner_id' => $owners[$i]->id,
                'name' => $publishingHouseNames[$i],
                'email' => strtolower(str_replace(' ', '', $publishingHouseNames[$i])) . '@example.com',
                'phone' => '+1987654321' . $i,
                'address' => ($i + 1) . '00 Publishing St, Book City, BC 1000' . $i,
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $publishingHouseNames[$i])) . '.com',
                'established_year' => (1950 + ($i * 10)) . '-01-01',
                'description' => 'A leading publishing house specializing in various genres.',
                'social_links' => [
                    'facebook' => 'https://facebook.com/' . strtolower(str_replace(' ', '', $publishingHouseNames[$i])),
                    'twitter' => 'https://twitter.com/' . strtolower(str_replace(' ', '', $publishingHouseNames[$i])),
                    'instagram' => 'https://instagram.com/' . strtolower(str_replace(' ', '', $publishingHouseNames[$i]))
                ],
                'status' => 'active'
            ]);
        }

        // Create Authors
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
            $publishingHouseIndex = $i % 5;
            $authors[] = Author::create([
                'name' => $authorNames[$i],
                'bio' => 'A renowned author known for engaging storytelling.',
                'publishing_house_id' => $publishingHouses[$publishingHouseIndex]->id,
            ]);
        }

        // Create Books
        $bookGenres = ['Mystery', 'Romance', 'Thriller', 'Adventure', 'Drama', 'Comedy', 'Horror', 'Fantasy', 'Sci-Fi', 'Historical'];
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
                    'description' => "An engaging {$genre} novel.",
                    'price' => rand(10, 50) + (rand(0, 99) / 100),
                    'language' => ['English', 'French', 'Arabic'][rand(0, 2)],
                    'dimensions' => '6 x 9 inches',
                    'pages_count' => rand(200, 500),
                    'images' => ['book_image_1.jpg', 'book_image_2.jpg'],
                    'cover' => 'book_cover_' . ($authorIndex + 1) . '_' . ($bookIndex + 1) . '.jpg'
                ]);
            }
        }

        // Seed Stock
        foreach (Book::all() as $book) {
            Stock::create([
                'book_id' => $book->id,
                'quantity' => rand(10, 100),
                'publishing_house_id' => $book->publishing_house_id,
            ]);
        }

        // Seed Orders and Order Items
        $client = $clients[0];
        $order = Order::create([
            'user_id' => $client->id,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'phone' => $client->phone,
            'wilaya' => 'Algiers',
            'commune' => 'Algiers',
            'address' => '123 Street, Algiers',
            'delivery_type_id' => 1, // Adjust if delivery types exist
            'order_status' => OrderStatus::PENDING,
            'payment_status' => PaymentStatus::PENDING,
            'payment_method' => PaymentMethod::OFFLINE,
        ]);

        $books = Book::inRandomOrder()->take(3)->get();
        $profitPercentage = PlatformSettings::first()->profit_percentage;
        foreach ($books as $book) {
            $quantity = rand(1, 5);
            $unitPrice = $book->price;
            $commission = $unitPrice * $quantity * ($profitPercentage / 100);

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $book->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'commission' => $commission,
                'publishing_house_id' => $book->publishing_house_id,
                'profit_percentage' => $profitPercentage,
                'status' => OrderStatus::PENDING,
            ]);
        }

        // Output
        $this->command->info('✅ Successfully created:');
        $this->command->info('- 1 Admin');
        $this->command->info('- 4 Clients');
        $this->command->info('- 5 Publishing House Owners');
        $this->command->info('- 5 Publishing Houses');
        $this->command->info('- 10 Authors');
        $this->command->info('- 100 Books');
        $this->command->info('- Stock for all books');
        $this->command->info('- 1 Order with 3 OrderItems');
    }
}