<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of books with limited fields and filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $query = Book::query();

        // Apply filters
        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('publishing_house_id')) {
            $query->where('publishing_house_id', $request->publishing_house_id);
        }
        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $perPage = $request->input('per_page', 15);
        $books = $query->select('id', 'title', 'description', 'price', 'cover')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $books->items(),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ]
        ]);
    }

    /**
     * Display the specified book with all details.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with(['author', 'category', 'publishingHouse', 'discount'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    /**
     * Get related books for a specific book.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function relatedBooks($id)
    {
        $book = Book::findOrFail($id);

        // Get books with the same author or category
        $relatedBooks = Book::where('id', '!=', $id)
            ->where(function ($query) use ($book) {
                $query->where('author_id', $book->author_id)
                    ->orWhere('category_id', $book->category_id);
            })
            ->select('id', 'title', 'description', 'price', 'cover')
            ->limit(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $relatedBooks
        ]);
    }

    /**
     * Get books according to a category, with pagination and search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $categorySlug
     * @return \Illuminate\Http\Response
     */
    public function booksByCategory(Request $request, $categorySlug)
    {
        $query = Book::whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }
        $perPage = $request->input('per_page', 15);
        $books = $query->select('id', 'title', 'description', 'price', 'cover')->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'data' => $books->items(),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ]
        ]);
    }

    /**
     * Get books according to an author, with pagination and search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $authorId
     * @return \Illuminate\Http\Response
     */
    public function booksByAuthor(Request $request, $authorId)
    {
        $query = Book::where('author_id', $authorId);
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }
        $perPage = $request->input('per_page', 15);
        $books = $query->select('id', 'title', 'description', 'price', 'cover')->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'data' => $books->items(),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ]
        ]);
    }
}
