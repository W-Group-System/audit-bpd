<?php

namespace App\Http\Controllers;

use App\CorrectiveAction;
use App\CorrectiveActionRequest;
use App\CorrectiveActionRequestApprover;
use App\CorrectiveActionRequestVerifier;
use App\Mail\ReturnEmail;
use App\Notifications\ClosedCarNotification;
use App\Notifications\ForApprovedCorrection;
use App\RemarksHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $approvers = CorrectiveActionRequestApprover::with('correctiveActionRequest')->where('user_id', auth()->user()->id)->get();
        $verifiers = CorrectiveActionRequestVerifier::with('correctiveActionRequest')->where('user_id', auth()->user()->id)->get();
        $car_count = CorrectiveActionRequest::where('status','!=','Closed')->count();
        if(auth()->user()->role->name == "Administrator")
        {
            $approvers = CorrectiveActionRequestApprover::with('correctiveActionRequest')->where('status', 'Pending')->get();
            $verifiers = CorrectiveActionRequestVerifier::with('correctiveActionRequest')->where('status','Pending')->get();
        }
        
        return view('for_approval.index', compact('approvers', 'verifiers','car_count'));
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

            $corrective_action_request = CorrectiveActionRequest::with('correctiveAction','correctionImmediateAction')->findOrFail($request->car_id);
            if (auth()->user()->role->name == 'Auditor')
            {
                $corrective_action_request->status = 'Approval CAR';
            }
            elseif(auth()->user()->role->name == 'Audit Head')
            {
                $corrective_action_request->status = 'For Implementation';
            }
            else
            {
                $corrective_action_request->status = 'For Review CAR';
            }
            $corrective_action_request->save();

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

            if (count($approvers) == 0)
            {
                $correction_action_date = ($corrective_action_request->correctionImmediateAction)->pluck('correction_action_date')->toArray();
                $corrective_action_date = ($corrective_action_request->correctiveAction)->pluck('action_date')->toArray();

                $corrective_action_request->auditee->notify(new ForApprovedCorrection($corrective_action_request,$correction_action_date,$corrective_action_date));
                $corrective_action_request->auditor->notify(new ForApprovedCorrection($corrective_action_request,$correction_action_date,$corrective_action_date));
            }

            Alert::success('Successfully Approved')->persistent('Dismiss');
        }
        elseif($request->action == 'Returned')
        {
            $approver_data = CorrectiveActionRequestApprover::with('correctiveActionRequest.auditee')->where('corrective_action_request_id', $request->car_id)
                ->where('status', 'Pending')
                ->where('user_id', auth()->user()->id)
                ->orderBy('level', 'asc')
                ->first();

            $approver_data->status = 'Returned';
            $approver_data->remarks = $request->remarks;
            $approver_data->save();

            $corrective_action_request = CorrectiveActionRequest::findOrFail($request->car_id);
            $corrective_action_request->status = 'Fill-Out';
            $corrective_action_request->save();

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

            // Mail::to($approver_data->correctiveActionRequest->auditee->email)->send(new ReturnEmail($corrective_action_request, $request->remarks));

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
        $car = CorrectiveActionRequest::with('verify','remarksHistory.correctiveAction', 'remarksHistory.correctionImmediateAction')->findOrFail($id);

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
        $verifier = CorrectiveActionRequestVerifier::where('status', 'Pending')->where('corrective_action_request_id', $request->car_id)->first();
        $verifier->status = $request->action;
        $verifier->remarks = $request->remarks;
        $verifier->save();

        if ($request->action == 'Approved')
        {
            $corrective_action_request = CorrectiveActionRequest::findOrFail($request->car_id);
            if (auth()->user()->role->name == 'Auditor')
            {
                $corrective_action_request->status = 'For Closing';
            }
            // elseif(auth()->user()->role->name == 'Auditee')
            // {
            //     $corrective_action_request->status = 'For Verification';
            // }
            $corrective_action_request->save();

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
                $verifiers = CorrectiveActionRequestVerifier::where('corrective_action_request_id', $request->car_id)->where('user_id', auth()->user()->id)->first();
                $verifiers->status = "Approved";
                $verifiers->save();

                $corrective_action = CorrectiveActionRequest::findOrFail($request->car_id);
                $corrective_action->status = 'Closed';
                $corrective_action->save();

                $corrective_action_request->auditee->notify(new ClosedCarNotification($corrective_action_request));
                $corrective_action_request->auditor->notify(new ClosedCarNotification($corrective_action_request));
            }

            Alert::success('Successfully Approved')->persistent('Dismiss');
        }
        else
        {
            $corrective_action_request = CorrectiveActionRequest::findOrFail($request->car_id);
            $corrective_action_request->status = 'For Implementation';
            $corrective_action_request->save();

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

        return redirect('for-approval');
    }
}
