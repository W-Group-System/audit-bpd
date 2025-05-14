<?php

namespace App\Http\Controllers;

use App\CorrectiveAction;
use App\CorrectiveActionRequest;
use App\CorrectiveActionRequestApprover;
use App\CorrectiveActionRequestVerifier;
use App\RemarksHistory;
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
        $verifiers = CorrectiveActionRequestVerifier::with('correctiveActionRequest')->where('user_id', auth()->user()->id)->where('status','Pending')->get();
        
        return view('for_approval.index', compact('approvers', 'verifiers'));
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
        $car = CorrectiveActionRequest::with('verify','remarksHistory.correctiveAction')->findOrFail($id);

        return view('for_approval.show', compact('car'));
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

    public function verifyAction(Request $request)
    {
        // dd($request->all());
        $verifier = CorrectiveActionRequestVerifier::where('status', 'Pending')->first();
        $verifier->status = $request->action;
        $verifier->remarks = $request->remarks;
        $verifier->save();

        $corrective_actions = CorrectiveAction::where('corrective_action_request_id', $request->car_id)->get();
        foreach($corrective_actions as $key=>$corrective_action)
        {
            $corrective_action->status = $request->status[$key];
            $corrective_action->remarks = $request->remarks_action[$key];
            $corrective_action->save();
        }

        if ($request->action == 'Approved')
        {
            $verifiers = CorrectiveActionRequestVerifier::where('corrective_action_request_id', $request->car_id)->where('status', 'Waiting')->orderBy('level','asc')->get();
            if ($verifiers->isNotEmpty())
            {
                foreach($verifiers as $key => $verifier)
                {
                    if ($key == 0)
                    {
                        $verifier->status = 'Pending';
                    }
                    else
                    {
                        $verifier->status = 'Waiting';
                    }
                    $verifier->save();
                }
            }
            else
            {
                $corrective_action = CorrectiveActionRequest::findOrFail($request->car_id);
                $corrective_action->status = 'Closed';
                $corrective_action->save();
            }

            Alert::success('Successfully Approved')->persistent('Dismiss');
        }
        else
        {
            $verifiers = CorrectiveActionRequestVerifier::where('corrective_action_request_id', $request->car_id)->orderBy('level','asc')->get();
            foreach($verifiers as $key => $verifier)
            {
                if ($key == 0)
                {
                    $verifier->status = 'Pending';
                }
                else
                {
                    $verifier->status = 'Waiting';
                }
                $verifier->save();
            }

            Alert::success('Successfully Returned')->persistent('Dismiss');
        }

        foreach($request->status as $key=>$status)
        {
            $remarks_history = new RemarksHistory;
            $remarks_history->corrective_action_request_id = $request->car_id;
            $remarks_history->status = $status;
            $remarks_history->remarks = $request->remarks_action[$key];
            $remarks_history->corrective_action_id = $corrective_action->id;
            $remarks_history->save();
        }

        return redirect('for-approval');
    }
}
