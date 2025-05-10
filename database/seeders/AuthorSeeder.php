<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['name' => 'J.K. Rowling', 'bio' => 'British author, best known for Harry Potter.', 'avatar' => null],
            ['name' => 'George Orwell', 'bio' => 'Author of 1984 and Animal Farm.', 'avatar' => null],
            ['name' => 'Malcolm Gladwell', 'bio' => 'Canadian journalist and author.', 'avatar' => null],
            ['name' => 'Stephen King', 'bio' => 'Author of horror and suspense novels.', 'avatar' => null],
            ['name' => 'Agatha Christie', 'bio' => 'Famous for detective novels.', 'avatar' => null],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
