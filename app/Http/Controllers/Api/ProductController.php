<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getSingleProduct($slug)
    {
        $product = DB::table('products')->where('products.slug', $slug)
            ->select('products.*', DB::raw('GROUP_CONCAT(DISTINCT categories.name SEPARATOR ", ") as category_names'), 'manufacturers.name as manufacturer_name')
            ->join('category_product', 'category_product.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_product.category_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
            ->groupBy('products.id', 'products.name', 'products.slug', 'manufacturers.name')
            ->first();
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function getCategoryCollection($slug)
    {
        $category = DB::table('categories')->where('slug', $slug)->first();
        if ($category) {
            $products = DB::table('products')->where('category_id', $category->id)
                ->select('products.*', DB::raw('GROUP_CONCAT(DISTINCT categories.name SEPARATOR ", ") as category_names'), 'manufacturers.name as manufacturer_name')
                ->join('category_product', 'category_product.product_id', '=', 'products.id')
                ->join('categories', 'categories.id', '=', 'category_product.category_id')
                ->join('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
                ->groupBy('products.id', 'products.name', 'products.slug', 'manufacturers.name')
                ->get();
            if ($products) {
                return response()->json($products);
            } else {
                return response()->json(['error' => 'There is no product in this category.'], 404);
            }
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }
}
