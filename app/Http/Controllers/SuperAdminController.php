<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    //
    public function staffList(){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $users = tbl_user::whereIn('role', ['staff', 'technician'])->orderBy('created_at')->get();

        return view('superadmin.staffListPage.staffListPage', [
            'users' => $users
        ]);
    }
}
