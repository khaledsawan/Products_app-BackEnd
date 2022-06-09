<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\support\Facades\Auth;

class AuthorController extends Controller
{
    //REGISTER METHOD POST
    public function register(Request $request)
    {
        //validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:authors",
            "password" => "required|confirmed",
            "phone_no" => "required"
        ]);
        //ctreate data
        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone_no = $request->phone_no;
        $author->password = bcrypt($request->password);

        //save data and send response
        $author->save();
        // json(['user'=>$author])
        return response()->json(['user' => $author]);
    }
    //LOGIN METHOD POST
    public function login(Request $request)
    {
        //validation

        $login_data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        //validate Author data
        if (!Auth::attempt($login_data)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"
            ]);
        }
        //token
        $token = Auth()->user()->createToken("auth_token")->accessToken;
        //send response
        return response()->json([

            "user" => Auth()->user(),
            "access_token" => $token,

        ]);
    }
    //PROFILE METHOD GET
    public function profile()
    {
        $user_data = auth()->user();

        return $user_data;
    }
    //LOGOUTMETHOD POST
    public function logout(Request $request)
    {
        //grt token value
        $token = $request->user()->token();

        // revoke this token value
        $token->revoke();
        return $token;
    }
}
