<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AuthorController extends Controller
{
    /**
     * Display a listing of the authors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::get()->map(function ($author) {
            $author->avatar = url('storage/' . $author->avatar);
            return $author;
        });

        return response()->json([
            'status' => 'success',
            'data' => $authors
        ]);
    }

    /**
     * Get a specific author by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAuthorById($id)
    {
        $author = Author::findOrFail($id);
        $author->avatar = URL::to('storage/' . $author->avatar);

        return response()->json([
            'status' => 'success',
            'data' => $author
        ]);
    }

    /**
     * Get all authors with pagination and search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllAuthors(Request $request)
    {
        $query = Author::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }
        $perPage = $request->input('per_page', 15);
        $authors = $query->select('id', 'name', 'bio', 'avatar')->paginate($perPage);

        // Modify the avatar URL
        $authors->getCollection()->transform(function ($author) {
            $author->avatar = URL::to('storage/' . $author->avatar);
            return $author;
        });

        return response()->json([
            'status' => 'success',
            'data' => $authors->items(),
            'meta' => [
                'current_page' => $authors->currentPage(),
                'last_page' => $authors->lastPage(),
                'per_page' => $authors->perPage(),
                'total' => $authors->total(),
            ]
        ]);
    }
}
