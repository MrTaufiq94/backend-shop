<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json([
            'success'       => true,
            'message'       => 'List Data Category',
            'categories'    => $categories
        ]);
    }
    
    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if($category) {

            return response()->json([
                'success' => true,
                'message' => 'List Product By Category: '. $category->name,
                "product" => $category->products()->latest()->get()
            ], 200);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Data Product By Category Tidak Ditemukan',
            ], 404);

        }
    }
    
    /**
     * categoryHeader
     *
     * @return void
     */
    public function categoryHeader()
    {
        $categories = Category::latest()->take(5)->get();
        return response()->json([
            'success'       => true,
            'message'       => 'List Data Category Header',
            'categories'    => $categories
        ]);
    }

}