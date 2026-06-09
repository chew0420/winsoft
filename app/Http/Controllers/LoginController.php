<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    function index(){
        return view("visitor.login.login");
    }

    function check(Request $request){
        session()->flush();
        session()->start();

        $email = $request->input('email');
        $password = $request->input('password');

        $userInfo = DB::table('tbl_user')->where('email', $email)->first();

        if ($userInfo){
            if (Hash::check($password, $userInfo->password)) {
                return $this->handleSuccessfulLogin($request, $userInfo, $email);
            }
        }

        return redirect()->back()->with('fail', 'Email or Password is Invalid !');
    }

    private function clearSession($request)
    {
        $request->session()->remove('LoggedCustomer');
        $request->session()->remove('LoggedStaff');
        $request->session()->remove('LoggedTechnician');
        $request->session()->remove('LoggedSuperadmin');
    }

    private function handleSuccessfulLogin($request, $userInfo, $email)
    {   
        if ($userInfo->role === 'customer') {
            $request->session()->put('LoggedCustomer', $userInfo->email);
            return redirect('customerHomePage');

        } else if ($userInfo->role === 'admin') {
            $request->session()->put('LoggedAdmin', $userInfo->email);
            return redirect('superadminHomePage');

        } else if ($userInfo->role === 'staff') {
            $request->session()->put('LoggedStaff', $userInfo->email);
            return redirect('staffHomePage');
            
        } else if ($userInfo->role === 'technician') {
            $request->session()->put('LoggedTechnician', $userInfo->email);
            return redirect('technicianHomePage');
        }
    }
}
