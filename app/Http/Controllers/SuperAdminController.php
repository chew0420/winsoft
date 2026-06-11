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

    public function addStaff()
    {
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        
        return view('superadmin.addStaffPage.addStaffPage');
    }

    public function storeStaff(Request $request){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:tbl_user,email',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:staff,technician',
            'password' => 'required|min:6'
        ]);

        $user = new tbl_user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->status = 'active';
        $user->save();

        return redirect('/superadmin/staffList')->with('success', 'Staff added successfully!');
    }

    public function deleteStaff($id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $user = tbl_user::find($id);

        if($user) {
            $user->delete();
            return redirect('/superadmin/staffList')->with('success', 'Staff deleted successfully!');
        }

        return redirect('/superadmin/staffList')->with('error', 'User not found');
    }
}
