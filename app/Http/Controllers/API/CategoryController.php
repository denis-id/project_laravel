<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategory(Request $request)
    {
        $categories = Category::where('is_active', true)->get(['name', 'is_active']);
        
        return response()->json($categories);
    }
}