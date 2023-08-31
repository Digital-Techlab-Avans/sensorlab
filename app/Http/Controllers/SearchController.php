<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class SearchController extends Controller
{
    public function autocomplete(Request $request, $query): \Illuminate\Http\JsonResponse
    {
        $query = strtolower($query);

        $result = Product::where('name', 'LIKE', '%'.$query.'%')->orderBy('name')->get();

        return response()->json($result);
    }
}
