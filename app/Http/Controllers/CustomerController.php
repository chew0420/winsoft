<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_category;
use App\Models\tbl_user;
use App\Models\tbl_service_request;
use App\Models\tbl_cart;
use App\Models\tbl_order;
use App\Models\tbl_contact_message;

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

        $validated = $request->validate([
            'service_type' => 'required|string|max:50',
            'service_option' => 'required|in:walk-in,door-to-door',
            'device_type' => 'required|string|max:50',
            'device_brand' => 'required|string|max:50',
            'device_model' => 'nullable|string|max:100',
            'problem_description' => 'required|string|max:2000',
            'service_location' => 'nullable|required_if:service_option,walk-in|in:Winsoft Solution (HQ),Winsoft Solution (BP)',
            'address' => 'nullable|required_if:service_option,door-to-door|string|max:500',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|date_format:H:i'
        ]);

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $service = new tbl_service_request();
        $service->customer_id = $customer->user_id;
        $service->service_type = $validated['service_type'];
        $service->service_option = $validated['service_option'];
        $service->device_type = $validated['device_type'];
        $service->device_brand = $validated['device_brand'];
        $service->device_model = $validated['device_model'] ?? null;
        $service->problem_description = $validated['problem_description'];
        $service->preferred_date = $validated['preferred_date'];
        $service->preferred_time = $validated['preferred_time'];
        $service->status = 'pending';

        if($validated['service_option'] === 'door-to-door') {
            $service->address = $validated['address'];
            $service->service_location = null;
        } else {
            $service->address = null;
            $service->service_location = $validated['service_location'];
        }

        $service->save();

        return view('customer.servicePage.servicePage', [
            'customer' => $customer,
            'showPopup' => true,
            'requestId' => $service->request_id
        ]);
    }

    public function serviceRequests(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $status = $request->get('status', 'all');

        $query = tbl_service_request::where('customer_id', $customer->user_id)->with('technician');

        if($status !== 'all') {
            $query->where('status', $status);
        }

        $serviceRequests = $query->orderBy('created_at', 'desc')->paginate(8);

        $counts = [
            'pending' => tbl_service_request::where('customer_id', $customer->user_id)->where('status', 'pending')->count(),
            'confirmed' => tbl_service_request::where('customer_id', $customer->user_id)->where('status', 'confirmed')->count(),
            'in-progress' => tbl_service_request::where('customer_id', $customer->user_id)->where('status', 'in-progress')->count(),
            'completed' => tbl_service_request::where('customer_id', $customer->user_id)->where('status', 'completed')->count(),
            'cancelled' => tbl_service_request::where('customer_id', $customer->user_id)->where('status', 'cancelled')->count()
        ];

        return view('customer.serviceRequestPage.serviceRequestPage', [
            'customer' => $customer,
            'serviceRequests' => $serviceRequests,
            'current_status' => $status,
            'counts' => $counts
        ]);
    }

    public function cancelServiceRequest($id){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customer = tbl_user::where('email', session()->get('LoggedCustomer'))->first();

        if(!$customer) {
            return redirect('/login');
        }

        $updated = tbl_service_request::where('request_id', $id)
            ->where('customer_id', $customer->user_id)
            ->where('status', 'pending')
            ->update([
                'status' => 'cancelled',
                'technician_id' => null
            ]);

        if(!$updated) {
            return redirect()->back()->with('error', 'This service request cannot be cancelled.');
        }

        return redirect()->back()->with('success', 'Service request cancelled successfully.');
    }

    public function contactUs(){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customer = tbl_user::where('email', session()->get('LoggedCustomer'))
            ->where('role', 'customer')
            ->where('status', 'active')
            ->first();

        if(!$customer) {
            return redirect('/login');
        }

        return view('customer.contactUsPage.contactUsPage', ['customer' => $customer]);
    }

    public function storeContactMessage(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customer = tbl_user::where('email', session()->get('LoggedCustomer'))
            ->where('role', 'customer')
            ->where('status', 'active')
            ->first();

        if(!$customer) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|in:General Inquiry,Product Question,Order Inquiry,Service Booking,Technical Support,Feedback,Others',
            'message' => 'required|string|min:10|max:2000'
        ]);

        $contact = new tbl_contact_message();
        $contact->customer_id = $customer->user_id;
        $contact->name = $customer->name;
        $contact->email = $customer->email;
        $contact->phone = $validated['phone'] ?? null;
        $contact->subject = $validated['subject'];
        $contact->message = $validated['message'];
        $contact->status = 'unread';
        $contact->save();

        return redirect('/customer/contactUs')
            ->with('contact_success', true)
            ->with('message_id', $contact->message_id);
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

    public function checkout(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();
        
        $selectedIds = $request->input('selected_ids');

        if(!$selectedIds) {
            return redirect('/customer/cart')->with('error', 'Please select items to checkout');
        }

        $selectedIdsArray = explode(',', $selectedIds);

        $cartItems = tbl_cart::where('user_id', $customer->user_id)->whereIn('cart_id', $selectedIdsArray)->with('product')->get();

        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        $shipping = 10.00;
        $total = $subtotal + $shipping;

        return view('customer.checkoutPage.checkoutPage', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
            'selectedIds' => $selectedIds,
            'customer' => $customer
        ]);
    }

    public function placeOrder(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }

        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();

        $selectedIds = explode(',', $request->input('selected_ids'));
        $paymentMethod = $request->input('payment_method');
        $shippingAddress = $request->input('shipping_address');

        $cartItems = tbl_cart::where('user_id', $customer->user_id)
                         ->whereIn('cart_id', $selectedIds)
                         ->with('product')
                         ->get();

        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        $shipping = 10.00;
        $total = $subtotal + $shipping;

        $orderData = [];
        foreach($cartItems as $item) {
            $orderData[] = [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity
            ];
        }

        $order = new tbl_order();
        $order->user_id = $customer->user_id;
        $order->order_date = now();
        $order->total_price = $total;
        $order->status = 'pending';
        $order->payment_status = 'paid';
        $order->shipping_address = $shippingAddress ?? $customer->address;
        $order->payment_method = $paymentMethod;
        $order->order_items = json_encode($orderData); // Store items as JSON
        $order->save();

        foreach($cartItems as $item) {
            $product = tbl_product::find($item->product_id);
            if($product) {
                $product->stock_quantity -= $item->quantity;
                $product->save();
            }
        }

        tbl_cart::where('user_id', $customer->user_id)->whereIn('cart_id', $selectedIds)->delete();

        return redirect('/customer/cart')->with('success', 'Order placed successfully! Order ID: #' . $order->order_id);
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

    public function updateOrderStatus(Request $request){
        if(!session()->has('LoggedCustomer')) {
            return redirect('/login');
        }
        
        $orderId = $request->order_id;
        $action = $request->action;
        
        $customerEmail = session()->get('LoggedCustomer');
        $customer = tbl_user::where('email', $customerEmail)->first();
        
        $order = tbl_order::where('order_id', $orderId)->where('user_id', $customer->user_id)->first();
        
        if(!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found!']);
        }
        if($action == 'received') {
            $order->status = 'completed';
            $order->save();
            
            return response()->json(['success' => true, 'message' => 'Order completed!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Invalid action']);
    }
}