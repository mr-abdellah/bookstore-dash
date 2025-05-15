<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a paginated listing of reviews for a book.
     *
     * @param  string  $bookId
     * @return \Illuminate\Http\Response
     */
    public function all($bookId)
    {
        $book = Book::findOrFail($bookId);
        
        $reviews = $book->reviews()
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $reviews
        ]);
    }
    
    /**
     * Store a newly created review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $bookId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        
        $review = new Review([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        $book->reviews()->save($review);
        
        return response()->json([
            'status' => 'success',
            'data' => $review->load('user:id,name,avatar')
        ], 201);
    }
    
    /**
     * Update the specified review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        // Check if the authenticated user owns this review
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'sometimes|required|string|max:1000',
        ]);
        
        $review->update($request->only(['rating', 'comment']));
        
        return response()->json([
            'status' => 'success',
            'data' => $review->load('user:id,name,avatar')
        ]);
    }
    
    /**
     * Remove the specified review.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $review = Review::findOrFail($id);
        
        // Check if the authenticated user owns this review
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $review->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Review deleted successfully'
        ]);
    }
}