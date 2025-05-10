<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PublishingHouse;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FakePopulateCommand extends Command
{
    protected $signature = 'fake:populate 
        {--users=20 : Number of users to create}
        {--books=100 : Number of books to create}
        {--orders=100 : Number of orders to create}
        {--clear : Clear existing data before populating}';

    protected $description = 'Populate the database with realistic fake data for demonstration';

    public function handle()
    {
        if ($this->option('clear')) {
            $this->clearData();
        }

        $userCount = (int) $this->option('users');
        $bookCount = (int) $this->option('books');
        $orderCount = (int) $this->option('orders');

        $this->info('Starting data population...');

        // Create Categories
        $this->info('Creating categories...');
        Category::factory()->count(10)->create();
        $this->comment('Created ' . Category::count() . ' categories.');

        // Create Delivery Types
        $this->info('Creating delivery types...');

        // Create Authors
        $this->info('Creating authors...');
        Author::factory()->count($bookCount / 5)->create();
        $this->comment('Created ' . Author::count() . ' authors.');

        // Create Publishing Houses
        $this->info('Creating publishing houses...');
        $owner = User::factory()->create(['role' => 'owner']);
        PublishingHouse::factory()->count($bookCount / 10)->create(['owner_id' => $owner->id]);
        $this->comment('Created ' . PublishingHouse::count() . ' publishing houses.');

        // Create Users
        $this->info('Creating users...');
        User::factory()->count($userCount)->create();
        $this->comment('Created ' . User::count() . ' users.');

        // Create Books and Stock
        $this->info('Creating books and stock...');
        Book::factory()->count($bookCount)->create();
        Book::all()->each(function ($book) {
            Stock::factory()->create(['book_id' => $book->id]);
        });
        $this->comment('Created ' . Book::count() . ' books and ' . Stock::count() . ' stock entries.');

        // Create Orders and Order Items
        $this->info('Creating orders and order items...');
        $faker = Faker::create();
        Order::factory()->count($orderCount)->create()->each(function ($order) use ($faker) {
            $items = OrderItem::factory()->count($faker->numberBetween(1, 3))->create([
                'order_id' => $order->id,
            ]);
            $order->update(['total' => $items->sum(fn($item) => $item->unit_price * $item->quantity)]);
        });
        $this->comment('Created ' . Order::count() . ' orders and ' . OrderItem::count() . ' order items.');

        $this->info('Data population completed successfully!');
    }

    protected function clearData()
    {
        $this->warn('Clearing existing data...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        OrderItem::truncate();
        Order::truncate();
        Stock::truncate();
        Book::truncate();
        PublishingHouse::truncate();
        Author::truncate();
        User::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->comment('Data cleared.');
    }
}
