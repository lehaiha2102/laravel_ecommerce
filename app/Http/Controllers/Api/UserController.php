<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Verify;

class UserController extends Controller
{
    public function userInfor($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ]);
        }
    }

    public function store(Request $request)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars_length = strlen($chars);
        $random_string = '';
        for ($i = 0; $i < 10; $i++) {
            $random_char = $chars[rand(0, $chars_length - 1)];
            $random_string .= $random_char;
        }
        $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        DB::table('users')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'password' => sha1($request->input('password')),
            'token' => $random_string,
            'expires_at' =>$expires_at,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        $user = [
            'email' => $request->input('email'),
            'token' => $random_string
        ];
    
        Mail::to($request->input('email'))->send(new Verify($user));
        return response()->json([
            'success' => true,
            'message' => 'An email has been sent to your email, check and verify your account..',
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
    public function verify($email, $token){
        $user = DB::table('users')->where('email', $email)->first();
        if($user->email == $email){
            if($user->token == $token){
                if (strtotime($user->expires_at) < time()) {
                    return response()->json(false);
                } else {
                    return response()->json(true);
                }
            } else{
                return response()->json('token wrong');
            }
        } else{
            return response()->json('email not found');
        }
    }
}
