<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_category;

class VisitorController extends Controller
{
    //
    public function shop(Request $request) {
        $categories = tbl_category::all();

        $selected_category = $request->input('category');
        $query = tbl_product::where('status', 'active');
        if($selected_category) {
            // First get the category ID from category name
            $category = tbl_category::where('name', $selected_category)->first();
            if($category) {
                $query->where('category_id', $category->category_id);
            }
        }
        $products = $query->get();

        if(session()->has('LoggedCustomer')) {
            return view('customer.shopPage.shopPage', ['products'=> $products , 'categories'=> $categories, 'selected_category' => $selected_category]);
        } else {
            return view('visitor.shopPage.shopPage', ['products'=> $products , 'categories'=> $categories, 'selected_category' => $selected_category]);
        }
    }
}
