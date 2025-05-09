<?php

namespace App\Http\Controllers;

use App\CorrectiveAction;
use App\CorrectiveActionRequest;
use App\CorrectiveActionRequestApprover;
use App\CorrectiveActionRequestAttachment;
use App\Department;
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
        $corrective_action_requests = CorrectiveActionRequest::with('auditor','auditee','department','correctiveAction','approver')->get();
        if(auth()->user()->role->name == 'Auditee')
        {
            $corrective_action_requests = CorrectiveActionRequest::with('auditor','auditee','department','correctiveAction','approver')->where('auditee_id', auth()->user()->id)->get();
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
        $car->status = 'Open';
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
        $car->immediate_action = $request->immediate_action;
        $car->action_date_immediate_action = $request->action_date_immediate_action;
        $car->verification_correction = $request->verification_correction;
        $car->status = 'In Progress';
        // $car->root_cause_analysis = $request->root_cause_analysis;
        // $car->action_date_root_cause = $request->action_date_root_cause;
        // $car->corrective_action = $request->corrective_action;
        // $car->action_date_corrective_action = $request->action_date_corrective_action;
        // $car->verification_corrective_action = $request->verification_corrective_action;
        $car->man = $request->man;
        $car->method = $request->method;
        $car->machine = $request->machine;
        $car->material = $request->material;
        $car->mother_nature = $request->mother_nature;
        $car->save();

        $corrective_action = CorrectiveAction::where('corrective_action_request_id', $id)->delete();
        foreach($request->corrective_action as $key=>$ca)
        {
            $corrective_action = new CorrectiveAction;
            $corrective_action->corrective_action_request_id = $car->id;
            $corrective_action->corrective_action = $ca;
            $corrective_action->action_date = $request->action_date[$key];
            $corrective_action->save();
        }

        $audit_head = User::where('role_id',4)->first();
        $approver_array = [
            $car->auditee_id,
            $car->auditor_id,
            $audit_head->id,
        ];
        $users = User::whereIn('id', $approver_array)->get();
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

        // $corrective_action_request_approver = CorrectiveActionRequestApprover::where('')
        
        // $files = $request->file('attachment');
        // foreach($files as $file)
        // {
        //     $name = time().'_'.$file->getClientOriginalName();
        //     $file->move(public_path('car_attachments'), $name);
        //     $file_name = '/car_attachments/'.$name;

        //     $car_attachment = new CorrectiveActionRequestAttachment;
        //     $car_attachment->corrective_action_request_id = $id;
        //     $car_attachment->extension = $file->getClientOriginalExtension();
        //     $car_attachment->name = $name;
        //     $car_attachment->file = $file_name;
        //     $car_attachment->save();
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
}
