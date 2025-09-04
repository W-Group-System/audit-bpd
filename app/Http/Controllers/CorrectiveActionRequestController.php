<?php

namespace App\Http\Controllers;

use App\CorrectionImmediateAction;
use App\CorrectiveAction;
use App\CorrectiveActionRequest;
use App\CorrectiveActionRequestApprover;
use App\CorrectiveActionRequestAttachment;
use App\CorrectiveActionRequestVerifier;
use App\Department;
use App\RemarksHistory;
use App\RootCauseAnalysis;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CorrectiveActionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereNull('status')->get();
        $departments = Department::whereNull('status')->get();
        $corrective_action_requests = CorrectiveActionRequest::with('auditor','auditee','department','correctiveAction.remarks_history','approver','verify')->get();
        if(auth()->user()->role->name == 'Auditee')
        {
            $corrective_action_requests = CorrectiveActionRequest::with('auditor','auditee','department','correctiveAction.remarks_history','approver','verify')->where('auditee_id', auth()->user()->id)->get();
        }

        return view('car.index', compact('users', 'corrective_action_requests', 'departments'));
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
        $car = new CorrectiveActionRequest;
        $car->standard_and_clause = $request->standard_and_clause;
        $car->department_id = $request->department;
        $car->classification_of_nonconformity = $request->classification_of_nonconformity;
        $car->nature_of_nonconformity = $request->nature_of_nonconformity;
        $car->type_of_nonconformity = $request->type_of_nonconformity;
        $car->auditor_id = $request->auditor;
        $car->auditee_id = $request->auditee;
        // $car->reference_document = $request->reference_document;
        $car->description_of_nonconformity = $request->description_of_nonconformity;
        $car->status = 'Fill-Out';
        $car->evidence = $request->evidence;
        if($request->has('upload_evidence'))
        {
            $file = $request->file('upload_evidence');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('evidence'), $name);
            $filename = '/evidence/'.$name;

            $car->evidence_attachment = $filename;
        }
        $car->save();

        Alert::success('Successfully Saved')->persistent('Dismiss');
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
        // dd($request->all());
        $car = CorrectiveActionRequest::findOrFail($id);
        // $car->immediate_action = $request->immediate_action;
        // $car->action_date_immediate_action = $request->action_date_immediate_action;
        // $car->verification_correction = $request->verification_correction;
        $car->status = 'Review CAR';
        $car->save();

        $correction_action = CorrectionImmediateAction::where('corrective_action_request_id',$id)->delete();
        foreach($request->correction_immediate_action as $key=>$correction_immediate_action)
        {
            $correction_action = new CorrectionImmediateAction;
            $correction_action->corrective_action_request_id = $id;
            $correction_action->correction_immediate_action = $correction_immediate_action;
            $correction_action->correction_action_date = $request->correction_action_date[$key];
            $correction_action->save();
        }

        $root_cause_analysis = RootCauseAnalysis::where('corrective_action_request_id', $id)->delete();
        foreach($request->man as $key=>$man)
        {
            $root_cause_analysis = new RootCauseAnalysis;
            $root_cause_analysis->corrective_action_request_id = $id;
            $root_cause_analysis->man = $man;
            $root_cause_analysis->method = $request->method[$key];
            $root_cause_analysis->machine = $request->machine[$key];
            $root_cause_analysis->material = $request->material[$key];
            $root_cause_analysis->mother_nature = $request->mother_nature[$key];
            $root_cause_analysis->save();
        }

        $corrective_action = CorrectiveAction::where('corrective_action_request_id', $id)->delete();
        foreach($request->corrective_action as $key=>$ca)
        {
            $corrective_action = new CorrectiveAction;
            $corrective_action->corrective_action_request_id = $car->id;
            $corrective_action->corrective_action = $ca;
            $corrective_action->action_date = $request->action_date[$key];
            $corrective_action->save();
        }

        $corrective_action_request_approver = CorrectiveActionRequestApprover::where('corrective_action_request_id', $id)->delete();
        $audit_head = User::where('role_id',4)->first();
        if ($car->department_id == 2)
        {
            $approver_array = [
                $car->auditee_id,
                $car->auditor_id
            ];
        }
        else
        {
            $approver_array = [
                $car->auditee_id,
                $car->auditor_id,
                $audit_head->id,
            ];
        }
            
        if ($car->department_id == 2)
        {
            $users = User::whereIn('id', $approver_array)->orderBy('role_id','desc')->get();
        }
        else
        {
            $users = User::whereIn('id', $approver_array)->orderBy('level','asc')->get();
        }
        
        foreach($users as $key=>$user)
        {
            $corrective_action_request_approver = new CorrectiveActionRequestApprover;
            $corrective_action_request_approver->user_id = $user->id;
            $corrective_action_request_approver->corrective_action_request_id = $id;
            $corrective_action_request_approver->level = $key+1;
            if ($key == 0)
            {
                $corrective_action_request_approver->status = 'Submitted';
            }
            elseif($key==1)
            {
                $corrective_action_request_approver->status = 'Pending';
            }
            else
            {
                $corrective_action_request_approver->status = 'Waiting';
            }
            $corrective_action_request_approver->save();
        }

        // if ($corrective_action_request_approver->isEmpty())
        // {
        //     $audit_head = User::where('role_id',4)->first();
        //     if ($car->department_id == 2)
        //     {
        //         $approver_array = [
        //             $car->auditee_id,
        //             $car->auditor_id
        //         ];
        //     }
        //     else
        //     {
        //         $approver_array = [
        //             $car->auditee_id,
        //             $car->auditor_id,
        //             $audit_head->id,
        //         ];
        //     }
            
        //     if ($car->department_id == 2)
        //     {
        //         $users = User::whereIn('id', $approver_array)->orderBy('role_id','desc')->get();
        //     }
        //     else
        //     {
        //         $users = User::whereIn('id', $approver_array)->orderBy('level','asc')->get();
        //     }
            
        //     foreach($users as $key=>$user)
        //     {
        //         $corrective_action_request_approver = new CorrectiveActionRequestApprover;
        //         $corrective_action_request_approver->user_id = $user->id;
        //         $corrective_action_request_approver->corrective_action_request_id = $id;
        //         $corrective_action_request_approver->level = $key+1;
        //         if ($key == 0)
        //         {
        //             $corrective_action_request_approver->status = 'Submitted';
        //         }
        //         elseif($key==1)
        //         {
        //             $corrective_action_request_approver->status = 'Pending';
        //         }
        //         else
        //         {
        //             $corrective_action_request_approver->status = 'Waiting';
        //         }
        //         $corrective_action_request_approver->save();
        //     }
        // }
        // else
        // {
        //     foreach($corrective_action_request_approver as $key=>$approver)
        //     {
        //         if ($key == 0)
        //         {
        //             $approver->status = 'Submitted';
        //         }
        //         elseif($key==1)
        //         {
        //             $approver->status = 'Pending';
        //         }
        //         else
        //         {
        //             $approver->status = 'Waiting';
        //         }
        //         $approver->save();
        //     }
        // }

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
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

    public function refreshDeptHead(Request $request)
    {
        // dd($request->all());
        $department_data = Department::where('id', $request->department_id)->first();
        $user = User::where('id', $department_data->user_id)->first();
        
        if ($user)
        {
            return "<option value='".$user->id."'>".$user->name."</option>";
        }
        
    }

    public function verify(Request $request, $id)
    {
        // dd($request->all(), $id);
        $car = CorrectiveActionRequest::findOrFail($id);
        $car->status = 'For Verification';
        if ($request->has('correction_immediate_action'))
        {
            $car->immediate_action = $request->correction_immediate_action;
            $car->action_date_immediate_action = $request->correction_immediate_action_date;
        }
        $car->save();

        if ($request->has('corrective_action'))
        {
            $corrective_actions = CorrectiveAction::where('corrective_action_request_id', $id)->get();
            foreach($corrective_actions as $key=>$corrective_action)
            {
                // $corrective_action = new CorrectiveAction;
                $corrective_action->corrective_action_request_id = $id;
                $corrective_action->corrective_action = $request->corrective_action[$key];
                $corrective_action->action_date = $request->action_date[$key];
                $corrective_action->save();
            }
        }
        
        $audit_head = User::whereNull('status')->where('role_id', 4)->first();
        $auditor = $car->auditor_id;
        if($car->department_id == 2)
        {
            $verifier_array = [
                $car->auditee_id,
                $auditor
            ];
        }
        else
        {
            $verifier_array = [
                $car->auditee_id,
                $auditor,
                $audit_head->id
            ];
        }

        $verify = CorrectiveActionRequestVerifier::where('corrective_action_request_id', $id)->orderBy('level','asc')->get();
        if ($verify->isNotEmpty())
        {
            foreach($verify as $key=>$verifier)
            {
                if ($key == 0)
                {
                    $verifier->status = 'Submitted';
                }
                elseif($key==1)
                {
                    $verifier->status = 'Pending';
                }
                else
                {
                    $verifier->status = 'Waiting';
                }
    
                $verifier->save();
            }
    
            Alert::success('Successfully Saved')->persistent('Dismiss');
            return back();
        }
        else
        {
            if($car->department_id == 2)
            {
                $users = User::whereIn('id', $verifier_array)->orderBy('role_id','desc')->get();
            }
            else
            {
                $users = User::whereIn('id', $verifier_array)->orderBy('level','asc')->get();
            }
            foreach($users as $key=>$user)
            {
                $corrective_action_request_verifier = new CorrectiveActionRequestVerifier;
                $corrective_action_request_verifier->corrective_action_request_id = $id;
                $corrective_action_request_verifier->user_id = $user->id;
                $corrective_action_request_verifier->level = $key+1;
    
                if ($key == 0)
                {
                    $corrective_action_request_verifier->status = 'Submitted';
                }
                elseif($key==1)
                {
                    $corrective_action_request_verifier->status = 'Pending';
                }
                else
                {
                    $corrective_action_request_verifier->status = 'Waiting';
                }
    
                $corrective_action_request_verifier->save();
            }
    
            Alert::success('Successfully Saved')->persistent('Dismiss');
            return back();
        }
    }
    
    public function updateAdmin(Request $request,$id)
    {
        // dd($request->all());
        $car = CorrectiveActionRequest::findOrFail($id);
        $car->standard_and_clause = $request->standard_and_clause;
        $car->department_id = $request->department;
        $car->classification_of_nonconformity = $request->classification_of_nonconformity;
        $car->nature_of_nonconformity = $request->nature_of_nonconformity;
        $car->type_of_nonconformity = $request->type_of_nonconformity;
        $car->auditor_id = $request->auditor;
        $car->auditee_id = $request->auditee;
        // $car->reference_document = $request->reference_document;
        $car->description_of_nonconformity = $request->description_of_nonconformity;
        // $car->status = 'Fill-Out';
        $car->evidence = $request->evidence;
        if($request->has('upload_evidence'))
        {
            $file = $request->file('upload_evidence');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('evidence'), $name);
            $filename = '/evidence/'.$name;

            $car->evidence_attachment = $filename;
        }
        $car->save();

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    public function updateCia(Request $request,$id)
    {
        // dd($request->all(),$id);
        // $corrective_action_request = CorrectiveActionRequest::findOrFail($id);
        // $corrective_action_request->immediate_action_status = $request->immediate_action_status;
        // $corrective_action_request->immediate_action_remarks = $request->immediate_action_remarks;
        // $corrective_action_request->approved_date = date('Y-m-d');
        // // File
        // if ($request->has('immediate_action_file'))
        // {
        //     $file = $request->file('immediate_action_file');
        //     $name = time().'_'.$file->getClientOriginalName();
        //     $file->move(public_path('immediate_action_file'), $name);
        //     $corrective_action_request->immediate_action_file = '/immediate_action_file/'.$name;
        // }
        // $corrective_action_request->save();

        $correction_immediate_actions = CorrectionImmediateAction::findMany($request->correction_immediate_action_id);
        foreach($correction_immediate_actions as $key=>$correction_immediate_action)
        {
            $correction_immediate_action->status = $request->immediate_action_status[$key];
            $correction_immediate_action->remarks = $request->immediate_action_remarks[$key];
            $correction_immediate_action->date_approved = date('Y-m-d');

            if (isset($request->immediate_action_file[$key]))
            {
                $files = $request->file('immediate_action_file')[$key];
                $name = time().'_'.$files->getClientOriginalName();
                $files->move(public_path('immediate_action_file'), $name);
                $correction_immediate_action->attachments = '/immediate_action_file/'.$name;
            }

            $correction_immediate_action->save();
        }

        foreach($request->immediate_action_status as $key=>$status)
        {
            $remarks_history = new RemarksHistory;
            $remarks_history->corrective_action_request_id = $id;
            $remarks_history->status =  $status;
            $remarks_history->remarks = $request->immediate_action_remarks[$key];
            $remarks_history->correction_immediate_action_id = $request->correction_immediate_action_id[$key];
            $remarks_history->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    public function updateCa(Request $request,$id)
    {
        // dd($request->all(),$id);
        $corrective_actions = CorrectiveAction::where('corrective_action_request_id', $id)->get();
        foreach($corrective_actions as $key=>$corrective_action)
        {
            if(isset($request->file('corrective_action_files')[$key]))
            {
                $files = $request->file('corrective_action_files')[$key];
                $name = time().'_'.$files->getClientOriginalName();
                $files->move(public_path('corrective_action_files'), $name);
                $corrective_action->file_attachments = '/corrective_action_files/'.$name;
            }
            
            $corrective_action->status = $request->status[$key];
            $corrective_action->remarks = $request->remarks_action[$key];
            $corrective_action->save();
        }

        foreach($request->status as $key=>$status)
        {
            $remarks_history = new RemarksHistory;
            $remarks_history->corrective_action_request_id = $id;
            $remarks_history->status =  $status;
            $remarks_history->remarks = $request->remarks_action[$key];
            $remarks_history->corrective_action_id = $request->corrective_action_id[$key];
            $remarks_history->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }
}
