<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $products = Product::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Products',
            'products'  => $products
        ], 200);
    }
    
    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if($product) {

            return response()->json([
                'success' => true,
                'message'   => 'Detail Data Product',
                'product' => $product
            ], 200);

        } else {

            return response()->json([
                'success' => false,
                'message'   => 'Data Product Tidak Ditemukan',
            ], 404);

        }
    }

}
