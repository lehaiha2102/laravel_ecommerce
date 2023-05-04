<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = DB::table('attributes')->get();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.add');
    }

    public function store(Request $request)
    {
        DB::table('attributes')->insert([
            'name' => $request->name
        ]);

        return redirect()->route('admin.attribute.index');
    }

    public function edit($id)
    {
        $attributes = DB::table('attributes')->where('id', $id)->get();

        return view('admin.attributes.edit', compact('attributes'));
    }
    public function update(Request $request, $id)
    {
        DB::table('attributes')->where('id', $id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.attribute.index');
    }
    public function destroy($id)
    {
        DB::table('attributes')->where('id', $id)->delete();
        return redirect()->route('admin.attribute.index');
    }
}
