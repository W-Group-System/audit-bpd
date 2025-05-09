<?php

namespace App\Http\Controllers;

use App\CorrectiveActionRequestApprover;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ForReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approvers = CorrectiveActionRequestApprover::with('correctiveActionRequest')->where('user_id', auth()->user()->id)->where('status', 'Pending')->get();
        
        return view('for_approval.index', compact('approvers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        
        if($request->action == 'Approved')
        {
            $approver_data = CorrectiveActionRequestApprover::where('corrective_action_request_id', $request->car_id)
                ->where('status', 'Pending')
                ->where('user_id', auth()->user()->id)
                ->orderBy('level', 'asc')
                ->first();
            $approver_data->status = 'Approved';
            $approver_data->remarks = $request->remarks;
            $approver_data->save();

            $approvers = CorrectiveActionRequestApprover::where('corrective_action_request_id', $request->car_id)->where('status', 'Waiting')->orderBy('level', 'asc')->get();
            
            foreach($approvers as $key=>$approver)
            {
                if ($key == 0)
                {
                    $approver->status = 'Pending';
                }
                else
                {
                    $approver->status = 'Waiting';
                }

                $approver->save();
            }

            Alert::success('Successfully Approved')->persistent('Dismiss');
        }
        elseif($request->action == 'Returned')
        {
            $approver_data = CorrectiveActionRequestApprover::where('corrective_action_request_id', $request->car_id)
                ->where('status', 'Pending')
                ->where('user_id', auth()->user()->id)
                ->orderBy('level', 'asc')
                ->first();

            // $approver_data->status = 'Returned';
            $approver_data->remarks = $request->remarks;
            $approver_data->save();

            $approvers = CorrectiveActionRequestApprover::where('corrective_action_request_id', $request->car_id)->orderBy('level', 'asc')->get();

            foreach($approvers as $key=>$approver)
            {
                if ($key == 0)
                {
                    $approver->status = 'Pending';
                }
                else
                {
                    $approver->status = 'Waiting';
                }
                $approver->save();
            }

            Alert::success('Successfully Returned')->persistent('Dismiss');
        }
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
