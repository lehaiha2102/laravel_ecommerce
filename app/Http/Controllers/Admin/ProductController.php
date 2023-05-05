<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\EditProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->select('products.*', DB::raw('GROUP_CONCAT(DISTINCT categories.name SEPARATOR ", ") as category_names'), 'manufacturers.name as manufacturer_name')
            ->join('category_product', 'category_product.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_product.category_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
            ->groupBy('products.id', 'products.name', 'products.slug', 'manufacturers.name')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $manufacturers = DB::table('manufacturers')->get();
        $categories = DB::table('categories')->get();
        $attributes = DB::table('attributes')->get();
        return view('admin.products.add', compact('categories', 'manufacturers', 'attributes'));
    }

    public function store(ProductRequest $request)
    {
        $uploadimages = array();
        if ($images = $request->file('images')) {
            foreach ($images as $image) {
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                $uploadimages[] = $imageName;
            }
        }
        $imagesJson = json_encode($uploadimages);

        $product_id = DB::table('products')->insertGetId([
            'name' => $request->name,
            'slug' => uniqid() . '-' . Str::slug($request->name),
            'manufacturer_id' => $request->manufacturer_id,
            'import_price' => $request->import_price,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'images' => $imagesJson,
            'status' => true,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        $categoryIds = $request->input('category_id', []);
        foreach ($categoryIds as $categoryId) {
            DB::table('category_product')->insert([
                'product_id' => $product_id,
                'category_id' => $categoryId,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()')
            ]);
        }
        return redirect()->route('admin.product.index');
    }

    public function edit($id)
    {
        $products = DB::table('products')
            ->where('products.id', $id)
            ->select(
                'products.*',
                DB::raw('GROUP_CONCAT(DISTINCT categories.name SEPARATOR ", ") as category_names'),
                DB::raw('GROUP_CONCAT(DISTINCT categories.id SEPARATOR ", ") as category_ids'),
                'manufacturers.name as manufacturer_name'
            )
            ->join('category_product', 'category_product.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_product.category_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
            ->groupBy('products.id')
            ->get();
        $categories = DB::table('categories')->get();
        $manufacturers = DB::table('manufacturers')->get();
        return view('admin.products.edit', compact('products', 'categories', 'manufacturers'));
    }

    public function update(EditProductRequest $request, $id){
        $product = DB::table('product')->where('id', $id)->first();
        if($product){

            // if ($request->hasFile('images')) {
            //     if (!empty($product->image)) {
            //         $filePath = public_path('images/products/' . $product->image);
            //         if (file_exists($filePath)) {
            //             if (!unlink($filePath)) {
            //                 toastr()->error('Failed to delete old image.');
            //                 return back();
            //             }
            //         }
            //     }
            //     $image = $request->file('image');
            //     $imageName = time() . '.' . $image->getClientOriginalExtension();
            //     $image->move(public_path('images/products'), $imageName);
            // } else {
            //     $imageName = $product->image;
            // }
        //    DB::table('products')->where('id', $id)->update([
        //         'name' => $request->name,
        //         'slug' => uniqid() . '-' . Str::slug($request->name),
        //         'manufacturer_id' => $request->manufacturer_id,
        //         'import_price' => $request->import_price,
        //         'price' => $request->price,
        //         'quantity' => $request->quantity,
        //         'description' => $request->description,
        //         'images' => $imagesJson,
        //         'status' => true,
        //         'updated_at' => DB::raw('NOW()')
        //     ]);
        //     $categoryIds = $request->input('category_id', []);
        //     foreach ($categoryIds as $categoryId) {
        //         DB::table('category_product')->insert([
        //             'product_id' => $id,
        //             'category_id' => $categoryId,
        //             'updated_at' => DB::raw('NOW()')
        //         ]);
        //     }
            toastr()->success('Update product success');
            return redirect()->route('admin.product.index');
        } else {
            toastr()->warning('Category id not found');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('admin.product.index');
    }

    public function changeStatus(Request $request)
    {
        $product = DB::table('products')->where('id', $request->product_id)->first();

        if ($product) {
            $new_status = $product->status == 1 ? 0 : 1;
            DB::table('products')->where('id', $request->product_id)->update(['status' => $new_status]);

            return response()->json([
                'success' => true,
                'message' => 'Changed status successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }
    }
}
