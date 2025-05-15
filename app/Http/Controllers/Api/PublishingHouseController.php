<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PublishingHouse;
use Illuminate\Http\Request;

class PublishingHouseController extends Controller
{
    // getAll: return only id and name
    public function getAll()
    {
        $houses = PublishingHouse::select('id', 'name')->get();
        return response()->json([
            'status' => 'success',
            'data' => $houses
        ]);
    }

    // index: return everything
    public function index()
    {
        $houses = PublishingHouse::all();
        return response()->json([
            'status' => 'success',
            'data' => $houses
        ]);
    }

    // show: return one by id
    public function show($id)
    {
        $house = PublishingHouse::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $house
        ]);
    }
}