<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();

        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = DB::table('roles')->get();
        return view('admin.users.add', compact('roles'));
    }
    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => sha1($request->password),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        toastr()->success('Create a new user successfully !!!');
        return redirect()->route('admin.user.index');
    }
    public function edit($id)
    {
        $users = DB::table('users')->where('id', $id)->get();
        $roles = DB::table('roles')->get();
        return view('admin.users.edit', compact('users', 'roles'));
    }
    public function update(Request $request, $id)
    {
        $users = DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => sha1($request->password),
            'updated_at' => DB::raw('NOW()')
        ]);
        toastr()->success('Update a user successfully.');
        return redirect()->route('admin.user.index');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        toastr()->success('Delete a user successfully.');
        return redirect()->route('admin.user.index');
    }
}
