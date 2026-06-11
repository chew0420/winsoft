<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_category;
use App\Models\tbl_user;
use App\Models\tbl_service_request;
use App\Models\tbl_cart;
use App\Models\tbl_order;

class CustomerController extends Controller
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

    public function bookService(){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $showPopup = false;
        $requestId = '';
        return view('customer.servicePage.servicePage', [
            'customer' => $customer,
            'showPopup' => $showPopup,
            'requestId' => $requestId
        ]);
    }

    public function storeService(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        // validate input
        $validated = $request->validate([
            'service_type' => 'required',
            'service_option' => 'required',
            'device_brand' => 'required',
            'problem_description' => 'required',
            'preferred_date' => 'required',
            'preferred_time' => 'required',
            'address' => 'nullable'
        ]);

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        // Insert service request
        $service = new tbl_service_request();
        $service->customer_id = $customer->user_id;
        $service->service_type = $request->service_type;
        $service->service_option = $request->service_option;
        $service->problem_description = $request->problem_description;
        $service->device_brand = $request->device_brand;
        $service->preferred_date = $request->preferred_date;
        $service->preferred_time = $request->preferred_time;
        $service->address = $request->address;
        $service->status = 'pending';
        $service->save();

        $requestId = $service->request_id;
        return view('customer.servicePage.servicePage', [
            'customer' => $customer,
            'showPopup' => true,
            'requestId' => $requestId
        ]);
    }

    public function contactUs(){
        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        return view('customer.contactUsPage.contactUsPage', ['customer' => $customer]);
    }

    public function storeLocation(){
        return view('customer.storeLocationPage.storeLocationPage');
    }

    public function productDetail ($id){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }
        
        $product = tbl_product::find($id);

        if(!$product){
            return redirect('/customer/shop')->with('error', 'Product not found');
        }

        $relatedProducts = tbl_product::where('category_id', $product->category_id)->where('product_id', '!=', $id)->take(4)->get();
        
        return view('customer.productDetailPage.productDetailPage', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function addToCart(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login')->with('error', 'Please login to add items to cart');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = tbl_product::find($request->product_id);

        if(!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        if($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available');
        }

        $cartItem = tbl_cart::where('user_id', $customer->user_id)->where('product_id', $request->product_id)->first();

        if($cartItem){
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }else{
            $cart = new tbl_cart();
            $cart->user_id = $customer->user_id;
            $cart->product_id = $product->product_id;
            $cart->quantity = $request->quantity;
            $cart->save();
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function viewCart(){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $cartItems = tbl_cart::where('user_id', $customer->user_id)->with('product')->get();

        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $shipping = 10.00;
        $total = $subtotal + $shipping;

        return view('customer.cartPage.cartPage', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total
        ]);
    }

    public function updateCart(Request $request){
        $cart = tbl_cart::find($request->cart_id);
        if($cart) {
            $cart->quantity = $request->quantity;
            $cart->save();
            
            $subtotal = $cart->product->price * $cart->quantity;
            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2)
            ]);
        }
        
        return response()->json(['error' => 'Cart item not found'], 404);
    }

    public function removeFromCart($id){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }
        
        $cart = tbl_cart::find($id);
        if($cart) {
            $cart->delete();
        }
        
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function viewProfile(){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        return view('customer.profilePage.profilePage', ['customer' => $customer]);
    }

    public function updateProfile(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:tbl_user,email,' . $customer->user_id . ',user_id',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);

        $isExist = tbl_user::where('email', $request->email)->where('user_id', '!=', $customer->user_id)->first();
        if($isExist != null){
            return redirect()->back()->with('error','Email Already Exist!');
        }else{
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone_number = $request->phone_number;
            $customer->address = $request->address;
            $customer->save();

            if($request->email != $customerEmail) {
                session()->put('LoggedCustomer', $request->email); 
            }
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }
    }

    public function order(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $status = $request->get('status', 'all');

        $query = tbl_order::where('user_id', $customer->user_id);
        
        switch($status){
            case 'to_pay':
                $query->where('payment_status', 'unpaid');
                break;
            case 'to_ship':
                $query->whereIn('status', ['pending', 'processing']);
                break;
            case 'to_receive':
                $query->whereIn('status', ['shipped', 'delivered']);
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
            default:
                // all orders
                break;
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        $counts = [
            'to_pay' => tbl_order::where('user_id', $customer->user_id)->where('payment_status', 'unpaid')->count(),
            'to_ship' => tbl_order::where('user_id', $customer->user_id)->whereIn('status', ['pending', 'processing'])->count(),
            'to_receive' => tbl_order::where('user_id', $customer->user_id)->whereIn('status', ['shipped', 'delivered'])->count(),
            'completed' => tbl_order::where('user_id', $customer->user_id)->where('status', 'completed')->count(),
            'cancelled' => tbl_order::where('user_id', $customer->user_id)->where('status', 'cancelled')->count(),
        ];

        return view('customer.viewOrderPage.viewOrderPage', [
            'customer' => $customer,
            'orders' => $orders,
            'current_status' => $status,
            'counts' => $counts
        ]);
    }
}
