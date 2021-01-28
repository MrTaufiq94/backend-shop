<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{       
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $carts = Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Cart',
            'cart'    => $carts
        ]);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $item = Cart::where('product_id', $request->product_id)->where('customer_id', $request->customer_id);

        if ($item->count()) {
            //increment quantity
            $item->increment('quantity');
            $item = $item->first();
            //sum price * quantity
            $price = $request->price * $item->quantity;
            //sum weight
            $weight = $request->weight * $item->quantity;
            $item->update([
                'price' => $price,
                'weight'=> $weight
            ]);
        } else {
            $item = Cart::create([
                'product_id'    => $request->product_id,
                'customer_id'   => $request->customer_id,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'weight'        => $request->weight
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success Add To Cart',
            'quantity'  => $item->quantity,
            'product'   => $item->product
        ]);
    }
    
    /**
     * getCartTotal
     *
     * @return void
     */
    public function getCartTotal()
    {
        $carts = Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->sum('price');
        
        return response()->json([
            'success' => true,
            'message' => 'Total Cart Price ',
            'total'   => $carts
        ]);
    }
    
    /**
     * getCartTotalWeight
     *
     * @return void
     */
    public function getCartTotalWeight()
    {
        $carts = Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->sum('weight');
        
        return response()->json([
            'success' => true,
            'message' => 'Total Cart Weight ',
            'total'   => $carts
        ]);
    }
    
    /**
     * removeCart
     *
     * @param  mixed $request
     * @return void
     */
    public function removeCart(Request $request)
    {
        Cart::with('product')
                ->whereId($request->cart_id)
                ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Remove Item Cart',
        ]);
    }
    
    /**
     * removeAllCart
     *
     * @param  mixed $request
     * @return void
     */
    public function removeAllCart(Request $request)
    {
        Cart::with('product')
                ->where('customer_id', auth()->guard('api')->user()->id)
                ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Remove All Item in Cart',
        ]);
    }
}