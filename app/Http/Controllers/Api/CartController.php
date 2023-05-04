<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function addItemCart($id, Request $request)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
                'cart'    => session()->get('cart'),
            ]);
        }
        $cart = array();
        $cart = session()->get('cart', []);
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->images,
            ];
        } else {
            $cart[$id]['quantity']++;
        }
        $minutes = 15552000;
        config(['session.lifetime' => $minutes]);
        session()->put('cart', $cart);
        return response()->json([
            'success' => true,
            'message' => 'Add product to cart successfully.',
            'cart'    => session()->get('cart'),
        ]);
    }
}
