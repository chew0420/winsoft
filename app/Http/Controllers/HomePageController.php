<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;


class HomePageController extends Controller
{
    //
    function index(){
        session()->start();
        
        if(session()->has('LoggedCustomer')){
            $userSession = session()->get('LoggedCustomer');
            $products = tbl_product::take(4)->get();
            return view('customer.homePage.homePage', ['userSession' => $userSession], ['products' => $products]);

        } else if(session()->has('LoggedAdmin')){
            $adminSession = session()->get('LoggedSuperadmin');
            return view('superadmin.homePage.homePage', ['adminSession' => $adminSession]);

        } else if(session()->has('LoggedStaff')){
            $staffSession = session()->get('LoggedStaff');
            return view('staff.homePage.homePage', ['staffSession' => $staffSession]);

        } else if(session()->has('LoggedTechnician')){
            $technicianSession = session()->get('LoggedTechnician');
            return view('technician.homePage.homePage', ['technicianSession' => $technicianSession]);

        } else {
            return view('login')->with('fail','Login expired,Please Login Again');
        }
        
    }
}
