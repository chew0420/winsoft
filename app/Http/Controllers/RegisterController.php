<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use Illuminate\Support\Facades\Hash; 

class RegisterController extends Controller
{
    function index(){
        return view('visitor.register.register');
    }

    public function store(Request $request){
        $email = $request -> input('email');
        $isExist = tbl_user::where('email', $email)->first();
        if($isExist != null){
            return redirect()->back()->with('error','Email Already Exist!');
        } else{
            $user = new tbl_user;
            $user -> name = $request->name;
            $user -> email = $request->email;
            $user -> phone_number = $request->phone_number;
            $user -> password = Hash::make($request->password);

            return redirect()->back()->with('success', 'Account Sucessfully Created');
        }
    }
}
