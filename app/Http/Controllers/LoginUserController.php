<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{

    public function login(Request $request){
        return view('auth.login');
    }



        public function store(Request $request){
        $request->validate([
           'email'=>'required|email',
           'password'=>'required|min:6'
        ]);

//        Attempt to logi in user

            if (Auth::guard('web')->attempt(
                [
                    'email'=>$request->email,
                    'password'=>$request->password
        ])){
                return redirect()->intended(route('posts.index'));
            }
            else{
                return  back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
    }



    public  function  logout(Request $request)
    {
                Auth::guard('web')->logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return to_route('posts.create');


    }


}
