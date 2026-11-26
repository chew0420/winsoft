<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\tbl_service_request;
use App\Models\tbl_user;

class TechnicianController extends Controller
{
    public function updateStatus(Request $request, $id){
        if(!session()->has('LoggedTechnician')) {
            return redirect('/login');
        }

        $technician = tbl_user::where('email', session()->get('LoggedTechnician'))
            ->where('role', 'technician')
            ->where('status', 'active')
            ->first();

        if(!$technician) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,in-progress,completed',
            'technician_notes' => 'required|string|max:2000',
            'quotation' => 'nullable|numeric|min:0|max:99999999.99',
            'final_price' => 'nullable|required_if:status,completed|numeric|min:0|max:99999999.99'
        ]);

        return DB::transaction(function() use ($validated, $technician, $id) {
            $job = tbl_service_request::where('request_id', $id)
                ->where('technician_id', $technician->user_id)
                ->lockForUpdate()
                ->first();

            if(!$job) {
                return redirect()->back()->with('error', 'Job not found or access denied.');
            }

            $allowedTransitions = [
                'pending' => ['confirmed'],
                'confirmed' => ['confirmed', 'in-progress'],
                'in-progress' => ['in-progress', 'completed']
            ];

            $status = $validated['status'];

            if(!in_array($status, $allowedTransitions[$job->status] ?? [])) {
                return redirect()->back()->with('error', 'Invalid job status transition.');
            }

            $currentDate = now()->format('d/m/Y H:i');
            $statusText = ucwords(str_replace('-', ' ', $status));
            $newNote = '['.$currentDate.'] '.$statusText.': '.$validated['technician_notes'];

            $job->technician_notes = $job->technician_notes
                ? $job->technician_notes."\n".$newNote
                : $newNote;

            $job->status = $status;

            if(isset($validated['quotation'])) {
                $job->quotation = $validated['quotation'];
            }

            if($status === 'completed') {
                $job->final_price = $validated['final_price'];
                $job->completed_date = now();
            }

            $job->save();

            return redirect()->back()->with('success', 'Job updated successfully!');
        });
    }

    public function jobHistory(){
        if(!session()->has('LoggedTechnician')) {
            return redirect('/login');
        }

        $technician = tbl_user::where('email', session()->get('LoggedTechnician'))
            ->where('role', 'technician')
            ->where('status', 'active')
            ->first();

        if(!$technician) {
            return redirect('/login');
        }

        $jobHistories = tbl_service_request::where('technician_id', $technician->user_id)
            ->where('status', 'completed')
            ->with('user')
            ->orderBy('completed_date', 'desc')
            ->get();

        return view('technician.jobHistoryPage.jobHistoryPage', [
            'jobHistories' => $jobHistories
        ]);
    }
}