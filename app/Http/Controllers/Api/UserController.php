<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function userInfor($id){
        $user = DB::table('users')->where('id', $id)->first();

        if($user){
            return response()->json($user);
        } else{
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ]);
        }
    }

    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'password' => sha1($request->input('password')),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Create a user success.',
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => sha1($request->password),
            'updated_at' => DB::raw('NOW()')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Update a user success.',
        ]);
    }
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete a user success.',
        ]);
    }
}
