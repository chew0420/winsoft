<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_category;

class PageController extends Controller
{
    public function index()
    {
        if(session()->has('LoggedCustomer') || session()->has("LoggedStaff") || session()->has('LoggedTechnician') || session()->has('LoggedSuperadmin'))
        {
            if (session()->has('LoggedCustomer')) {
                return redirect('/customerHomePage');
            } elseif (session()->has('LoggedStaff')) {
                return redirect('/superAdminHomePage');
            } elseif (session()->has('LoggedTechnician')) {
                return redirect('/technicianHomePage');
            } elseif (session()->has('LoggedSuperadmin')) {
                return redirect('/superadminHomePage');
            }
        }
        $products = tbl_product::take(4)->get();
        $categories = tbl_category::all();
        return view('visitor.homePage.homePage', ['products' => $products, 'categories'=> $categories]);
    }
}

