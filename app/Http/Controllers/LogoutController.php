<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    function logout(Request $request)
    {
        session()->flush();
        if($request->session()->has('LoggedCustomer')){
            $request->session()->remove('LoggedCustomer');
            return redirect('mainPage');

        }else if($request->session()->has('LoggedSuperadmin')){
            $request->session()->remove('LoggedSuperadmin');
            return redirect('mainPage');

        }else if($request->session()->has('LoggedStaff')){
            $request->session()->remove('LoggedStaff');
            return redirect('mainPage');

        }else if($request->session()->has('LoggedTechnician')){
            $request->session()->remove('LoggedTechnician');
            return redirect('mainPage');
            
        }else{
            $request->session()->flush();
            return redirect('mainPage');
        }
    }
}
