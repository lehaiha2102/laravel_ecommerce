<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManufacturerController extends Controller
{
    public function index(){
        $manufacturers = DB::table('manufacturers')->get();
        return view('admin.manufacturer.index', compact('manufacturers'));
    }

    public function create(){
        return view('admin.manufacturer.add');
    }
    public function store(Request $request)
    {
        DB::table('manufacturers')->insert([
            'name' => $request->name,
            'slug' => uniqid() . '-' . Str::slug($request->name),
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'status'=>true,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        return redirect()->route('admin.manufacturer.index');
    }
    public function edit($id){
        $manufacturers = DB::table('manufacturers')->where('id', $id)->get();
        return view('admin.manufacturer.edit', compact('manufacturers'));
    }
    public function update(Request $request, $id){
        DB::table('manufacturers')->where('id', $id)->update([
            'name' => $request->name,
            'slug' => uniqid() . '-' . Str::slug($request->name),
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'status'=>true,
            'updated_at' => DB::raw('NOW()')
        ]);

        return redirect()->route('admin.manufacturer.index');
    }
    public function destroy($id)
    {
        DB::table('manufacturers')->where('id', $id)->delete();
        return redirect()->route('admin.manufacturer.index');
    }
}
