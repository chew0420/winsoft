<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_user;
use App\Models\tbl_service_request;
use App\Models\tbl_order;


class HomePageController extends Controller
{
    //
    function index(){
        session()->start();
        
        if(session()->has('LoggedCustomer')){
            $userSession = session()->get('LoggedCustomer');
            $products = tbl_product::take(4)->get();
            return view('customer.homePage.homePage', ['userSession' => $userSession], ['products' => $products]);

        } else if(session()->has('LoggedSuperadmin')){
            $adminSession = session()->get('LoggedSuperadmin');
            $adminName = session()->get('LoggedSuperadmin');
            $admin = tbl_user::where('email', $adminName)->first();

            $totalUsers = tbl_user::count();
            $totalProducts = tbl_product::count();
            $totalServices = tbl_service_request::count();
            $totalOrders = tbl_order::count();

            $recentServices = tbl_service_request::orderBy('created_at', 'desc')->limit(5)->get();
            $recentUsers = tbl_user::orderBy('created_at', 'desc')->limit(5)->get();

            return view('superadmin.homePage.homePage', [
                'adminSession' => $adminSession, 
                'admin' => $admin, 
                'totalUsers' => $totalUsers, 
                'totalProducts' => $totalProducts, 
                'totalServices' => $totalServices, 
                'totalOrders' => $totalOrders, 
                'recentServices' => $recentServices, 
                'recentUsers' => $recentUsers]);

        } else if(session()->has('LoggedStaff')){
            $staffSession = session()->get('LoggedStaff');
            return view('staff.homePage.homePage', ['staffSession' => $staffSession]);

        } else if(session()->has('LoggedTechnician')){
            $technicianSession = session()->get('LoggedTechnician');
            $technician = tbl_user::where('email', $technicianSession)->first();

            $assignedJobs = tbl_service_request::where('technician_id', $technician->user_id)->orderBy('created_at', 'desc')->with('user')->get();
            return view('technician.homePage.homePage', ['assignedJobs' => $assignedJobs]);

        } else {
            return view('login')->with('fail','Login expired,Please Login Again');
        }
        
    }
}
