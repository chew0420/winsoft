<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_category;
use App\Models\tbl_user;
use App\Models\tbl_service_request;

class CustomerController extends Controller
{
    //
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
}
