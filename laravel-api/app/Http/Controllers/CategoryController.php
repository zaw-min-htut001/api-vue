<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Get Categories
    public function index()
    {
        try {
            $categories = Category::all();
            return $categories;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }
}
