<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->get();

        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        return view('admin.roles.add');
    }
    public function store(Request $request)
    {
        DB::table('roles')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        toastr()->success('Create a new role successfully !!!');
        return redirect()->route('admin.role.index');
    }
    public function edit($id)
    {
        $roles = DB::table('roles')->where('id', $id)->get();
        return view('admin.roles.edit', compact('roles'));
    }
    public function update(Request $request, $id)
    {
         DB::table('roles')->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => DB::raw('NOW()')
        ]);
        toastr()->success('Update a role successfully.');
        return redirect()->route('admin.role.index');
    }

    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        toastr()->success('Delete a role successfully.');
        return redirect()->route('admin.role.index');
    }

}
