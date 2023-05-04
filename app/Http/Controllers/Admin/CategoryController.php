<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')
            ->leftJoin('categories as parent_category', 'categories.parent_category', '=', 'parent_category.id')
            ->select('categories.*', 'parent_category.name as parent_name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        $categories = DB::table('categories')
            ->select('name', 'id')
            ->get();

        return view('admin.categories.add', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);
        }
        $parent_category = $request->parent_category !== '--Select--' ? $request->parent_category : null;
        DB::table('categories')->insert([
            'name' => $request->name,
            'slug' => uniqid() . '-' . Str::slug($request->name),
            'parent_category' => $parent_category,
            'image' => $imageName ?? null,
            'description' => $request->description,
            'status' => true,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        toastr()->success('Create a new category successfully !!!');
        return redirect()->route('admin.category.index');
    }
    public function edit($id)
    {
        $categories = DB::table('categories')->where('id', $id)->get();
        return view('admin.categories.edit', compact('categories'));
    }
    public function update(EditCategoryRequest $request, $id)
    {
        $categories = DB::table('categories')->where('id', $id)->first();
        if ($request->hasFile('image')) {
            if (!empty($categories->image)) {
                $filePath = public_path('images/categories/' . $categories->image);
                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        toastr()->error('Failed to delete old image.');
                        return back();
                    }
                }
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);
        } else {
            $imageName = $categories->image;
        }
        $parent_category = $request->parent_category !== '--Select--' ? $request->parent_category : null;
        DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
            'slug' => uniqid() . '-' . Str::slug($request->name),
            'parent_category' => $parent_category,
            'image' => $imageName,
            'description' => $request->description,
            'status' => true,
            'updated_at' => DB::raw('NOW()')
        ]);
        toastr()->success('Update a category successfully.');
        return redirect()->route('admin.category.index');
    }

    public function destroy($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if ($category && $category->image) {
            $imagePath = public_path('images/categories/' . $category->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        DB::table('categories')->where('id', $id)->delete();
        toastr()->success('Delete a category successfully.');
        return redirect()->route('admin.category.index');
    }

    public function changeStatus(Request $request)
    {
        $category = DB::table('categories')->where('id', $request->category_id)->first();

        if ($category) {
            $new_status = $category->status == 1 ? 0 : 1;
            DB::table('categories')->where('id', $request->category_id)->update(['status' => $new_status]);

            return response()->json([
                'success' => true,
                'message' => 'Changed status successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.'
            ]);
        }
    }
}
