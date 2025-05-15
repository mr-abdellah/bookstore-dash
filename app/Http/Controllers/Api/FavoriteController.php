<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a paginated listing of favorites for a book.
     *
     * @param  string  $bookId
     * @return \Illuminate\Http\Response
     */
    public function all($bookId)
    {
        $book = Book::findOrFail($bookId);

        $favorites = Favorite::where('book_id', $bookId)
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $favorites
        ]);
    }

    /**
     * Store a newly created favorite.
     *
     * @param  string  $bookId
     * @return \Illuminate\Http\Response
     */
    public function store($bookId)
    {
        $book = Book::findOrFail($bookId);

        // Check if the favorite already exists
        $existingFavorite = Favorite::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book is already in favorites'
            ], 422);
        }

        $favorite = new Favorite([
            'user_id' => auth()->id(),
            'book_id' => $bookId
        ]);

        $favorite->save();

        return response()->json([
            'status' => 'success',
            'data' => $favorite->load('user:id,first_name,last_name,avatar')
        ], 201);
    }

    /**
     * Update the specified favorite.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $favorite = Favorite::findOrFail($id);

        // Check if the authenticated user owns this favorite
        if ($favorite->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Since favorites don't have additional fields to update,
        // this method just confirms the favorite exists and belongs to the user

        return response()->json([
            'status' => 'success',
            'data' => $favorite->load('user:id,first_name,last_name,avatar')
        ]);
    }

    /**
     * Remove the specified favorite.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $favorite = Favorite::findOrFail($id);

        // Check if the authenticated user owns this favorite
        if ($favorite->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $favorite->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Favorite removed successfully'
        ]);
    }
}
