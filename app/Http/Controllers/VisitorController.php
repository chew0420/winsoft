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

        return view('visitor.shopPage.shopPage', ['products'=> $products , 'categories'=> $categories, 'selected_category' => $selected_category]);
    }

    public function contactUs(){
        return view('visitor.contactUsPage.contactUsPage');
    }

    public function storeLocation(){
        return view('visitor.storeLocationPage.storeLocationPage');
    }

    public function productDetail ($id){
        $product = tbl_product::find($id);

        if(!$product){
            return redirect('/customer/shop')->with('error', 'Product not found');
        }

        $relatedProducts = tbl_product::where('category_id', $product->category_id)->where('product_id', '!=', $id)->take(4)->get();
        
        return view('visitor.productDetailPage.productDetailPage', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function redirectlogin(){
        return view('visitor.login.login');
    }
}
