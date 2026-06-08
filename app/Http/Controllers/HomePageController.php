<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    //
    function index(){
        session()->start();

        if(session()->has('LoggedCustomer')){
            $userSession = session()->get('LoggedCustomer');
            return view('customerHomePage',['userSession' => $userSession]);

        } else if(session()->has('LoggedAdmin')){
            $adminSession = session()->get('LoggedSuperadmin');
            return view('superadminHomePage', ['adminSession' => $adminSession]);

        } else if(session()->has('LoggedStaff')){
            $staffSession = session()->get('LoggedStaff');
            return view('staffHomePage', ['staffSession' => $staffSession]);

        } else if(session()->has('LoggedTechnician')){
            $technicianSession = session()->get('LoggedTechnician');
            return view('technicianHomePage', ['technicianSession' => $technicianSession]);

        } else {
            return view('login')->with('fail','Login expired,Please Login Again');
        }
    }
}
