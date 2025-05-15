<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

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
}