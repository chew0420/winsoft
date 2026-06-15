<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_service_request;

class TechnicianController extends Controller
{
    //
    public function updateStatus(Request $request, $id){
        if(!session()->has('LoggedTechnician')) {
            return redirect('/login');
        }

        $job = tbl_service_request::find($id);
        if(!$job) {
            return redirect()->back()->with('error', 'Job not found');
        }

        $status = $request->input('status');
        $existingNote = $job->technician_notes;
        $currentDate = date('d/m/Y H:i');
        $note = $request->input('technician_notes');
        if($existingNote){
            $completeNote = $existingNote. "\n". $status. ' '. $currentDate. ' : '.$note;
        }else{
            $completeNote = $status. ' '. $currentDate. ' : '. $note;
        }
        

        $job->status = $status;
        $job->technician_notes = $completeNote;
        if($status == 'completed'){
            $price = $request->input('final_price');
            $job->final_price = $price;
            $job->completed_date = date('d/m/Y H:i');
        }
        $job->save();

        return redirect()->back()->with('success', 'Job status updated successfully!');
    }
}
