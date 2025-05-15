<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }


    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }


    /**
     * Get all categories with pagination and search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllCategories(Request $request)
    {
        $query = Category::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%$search%")
                    ->orWhere('name_fr', 'like', "%$search%")
                    ->orWhere('name_ar', 'like', "%$search%");
            });
        }
        $perPage = $request->input('per_page', 15);
        $categories = $query->select('id', 'name_en', 'name_fr', 'name_ar', 'slug')->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'data' => $categories->items(),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ]
        ]);
    }
}
