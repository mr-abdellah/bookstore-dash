<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Kossa\AlgerianCities\Wilaya;

class AddressController extends Controller
{
    public function wilayas()
    {
        $wilayas = Wilaya::all();
        return response()->json($wilayas);
    }

    public function communes($wilayaId)
    {
        $communes = Wilaya::find($wilayaId)->communes;
        return response()->json($communes);
    }
}
