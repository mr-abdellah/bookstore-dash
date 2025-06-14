<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\PublishingHouse;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $publishingHouse = PublishingHouse::first();
        $authors = [
            ['name' => 'J.K. Rowling', 'bio' => 'British author, best known for Harry Potter.', 'avatar' => null, 'publishing_house_id' => $publishingHouse->id],
            ['name' => 'George Orwell', 'bio' => 'Author of 1984 and Animal Farm.', 'avatar' => null, 'publishing_house_id' => $publishingHouse->id],
            ['name' => 'Malcolm Gladwell', 'bio' => 'Canadian journalist and author.', 'avatar' => null, 'publishing_house_id' => $publishingHouse->id],
            ['name' => 'Stephen King', 'bio' => 'Author of horror and suspense novels.', 'avatar' => null, 'publishing_house_id' => $publishingHouse->id],
            ['name' => 'Agatha Christie', 'bio' => 'Famous for detective novels.', 'avatar' => null, 'publishing_house_id' => $publishingHouse->id],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
