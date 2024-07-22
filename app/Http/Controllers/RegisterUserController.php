<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class RegisterUserController extends Controller
{
    public function register(Request $request){
        return view('auth.register');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' =>[ 'required','max:255','min:5','string'],
            'email' =>'required|min:8|unique:users|email',
            'password' => 'required|min:8|confirmed',

        ]);

    $user=User::create(
        [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make( $request->password)
        ]

    );

    auth()->login($user);
    return to_route('posts.index');


    }
}
