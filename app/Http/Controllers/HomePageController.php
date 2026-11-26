<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_user;
use App\Models\tbl_service_request;
use App\Models\tbl_order;
use App\Models\tbl_category;

class HomePageController extends Controller
{
    //
    function index(Request $request){
        session()->start();
        
        if(session()->has('LoggedCustomer')){
            $userSession = session()->get('LoggedCustomer');
            $products = tbl_product::take(4)->get();
            $categories = tbl_category::all();
            return view('customer.homePage.homePage', ['userSession' => $userSession, 'products' => $products, 'categories' => $categories]);

        } else if(session()->has('LoggedSuperadmin')){
            $adminSession = session()->get('LoggedSuperadmin');
            $adminName = session()->get('LoggedSuperadmin');
            $admin = tbl_user::where('email', $adminName)->first();

            $totalUsers = tbl_user::count();
            $totalProducts = tbl_product::count();
            $totalServices = tbl_service_request::count();
            $totalOrders = tbl_order::whereIn('status', ['pending', 'processing', 'shipped', 'delivered'])->count();

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

            $status = $request->get('status', 'all');
            $query = tbl_order::orderBy('created_at', 'desc');

            switch($status) {
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
                    break;
            }

            $orders = $query->paginate(15);

            foreach($orders as $order) {
                $customer = tbl_user::find($order->user_id);
                $order->customer_name = $customer ? $customer->name : 'Unknown';

                $order->order_items = json_decode($order->order_items, true);
            }

            $counts = [
                'all' => tbl_order::count(),
                'to_pay' => tbl_order::where('payment_status', 'unpaid')->count(),
                'to_ship' => tbl_order::whereIn('status', ['pending', 'processing'])->count(),
                'to_receive' => tbl_order::whereIn('status', ['shipped', 'delivered'])->count(),
                'completed' => tbl_order::where('status', 'completed')->count(),
                'cancelled' => tbl_order::where('status', 'cancelled')->count(),
            ];
            return view('staff.homePage.homePage', [
                'staffSession' => $staffSession,
                'orders' => $orders,
                'current_status' => $status,
                'counts' => $counts
            ]);

        } else if(session()->has('LoggedTechnician')){
            $technicianSession = session()->get('LoggedTechnician');

            $technician = tbl_user::where('email', $technicianSession)
                ->where('role', 'technician')
                ->where('status', 'active')
                ->first();

            if(!$technician) {
                session()->forget('LoggedTechnician');
                return redirect('/login');
            }

            $assignedJobs = tbl_service_request::where('technician_id', $technician->user_id)
                ->whereIn('status', ['pending', 'confirmed', 'in-progress'])
                ->with('user')
                ->orderBy('preferred_date', 'asc')
                ->orderBy('preferred_time', 'asc')
                ->get();

            $counts = [
                'all' => $assignedJobs->count(),
                'pending' => $assignedJobs->where('status', 'pending')->count(),
                'confirmed' => $assignedJobs->where('status', 'confirmed')->count(),
                'in-progress' => $assignedJobs->where('status', 'in-progress')->count(),
                'completed' => tbl_service_request::where('technician_id', $technician->user_id)->where('status', 'completed')->count()
            ];

            return view('technician.homePage.homePage', [
                'assignedJobs' => $assignedJobs,
                'technician' => $technician,
                'counts' => $counts
            ]);

        } else {
            return view('login')->with('fail', 'Login expired, Please Login Again');
        }
        
    }
}
