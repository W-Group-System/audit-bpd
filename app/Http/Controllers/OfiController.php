<?php

namespace App\Http\Controllers;

use App\CorrectionImmediateAction;
use App\Department;
use App\Ofi;
use App\OfiApprover;
use App\OfiAttachment;
use App\OfiImmediateAction;
use App\OfiRemarksHistory;
use App\OfiVerifier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OfiCreatedMail;
use RealRashid\SweetAlert\Facades\Alert;

class OfiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $ofis = Ofi::with('department','issuedBy','issuedTo')->get();
        $departments = Department::with('dept_head')->whereNull('status')->get();
        $users = User::whereNull('status')->get();
        $query = Ofi::with(
            'department',
            'issuedBy',
            'issuedTo'
        );

        if (auth()->user()->role->name == "Auditee")
        {
            $query->where('issued_to', auth()->user()->id)->get();
        };

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        if ($request->filled('department_filter')) {
            $query->where('department_id', $request->department_filter);
        }

        $ofis = $query->get();


        return view('ofi.index',
            array(
                'ofis' => $ofis,
                'departments' => $departments,
                'users' => $users
            )
        );
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
        $year = date('y');
        $latestOfi = Ofi::where('ofi_no', 'like', 'OFI-' . $year . '-%')
                    ->orderBy('id', 'desc')
                    ->first();
        if ($latestOfi) {
            $lastSequence = (int) substr($latestOfi->ofi_no, -3);
            $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextSequence = '001';
        }

        $ofiNumber = 'OFI-' . $year . '-' . $nextSequence;
        $ofi = new Ofi;
        $ofi->ofi_no = $ofiNumber;
        $ofi->department_id = $request->department;
        $ofi->issued_by = $request->auditor;
        $ofi->issued_to = $request->auditee;
        $ofi->recommendation = $request->recommendation;
        $ofi->description = $request->description;
        $ofi->status = "Pending";
        $ofi->save();

        $auditee = User::find($request->auditee);

        if ($auditee && !empty($auditee->email)) {
            Mail::to($auditee->email)->send(new OfiCreatedMail($ofi));
        }


        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    public function updateAdmin(Request $request,$id)
    {
        $ofi = Ofi::with('approver')->findOrFail($id);
        if (count($ofi->approver) > 0)
        {
            $approver = ($ofi->approver)->where('user_id', $ofi->issued_by)->first();
            $approver->user_id = $request->auditor;
            $approver->save();
        }

        $ofi->department_id = $request->department;
        $ofi->issued_by = $request->auditor;
        $ofi->issued_to = $request->auditee;
        $ofi->recommendation = $request->recommendation;
        $ofi->description = $request->description;
        
       
        $ofi->save();

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
        // dd($request->all(), $id);
        $ofi = Ofi::findOrFail($id);
        // $ofi->action_date = $request->action_date;
        $ofi->status = 'Review OFI';
        $ofi->save();
        
        // $ofi_attachment = OfiAttachment::where('ofi_id', $id)->delete();
        // $files = $request->file('files');
        // foreach($files as $file)
        // {
        //     $name = time()."_".$file->getClientOriginalName();
        //     $file->move(public_path('ofi_attachments'),$name);
        //     $attachment = '/ofi_attachments/'.$name;

        //     $ofi_attachment = new OfiAttachment;
        //     $ofi_attachment->ofi_id = $id;
        //     $ofi_attachment->attachment = $attachment;
        //     $ofi_attachment->save();
        // }
        $ofi_action = OfiImmediateAction::where('ofi_id',$id)->delete();
        foreach($request->ofi_immediate_action as $key=>$ofi_immediate_action)
        {
            $ofi_action = new OfiImmediateAction;
            $ofi_action->ofi_id = $id;
            $ofi_action->immediate_action = $ofi_immediate_action;
            $ofi_action->implementation_date = $request->ofi_implementation_date[$key];
            $ofi_action->save();
        }

        $ofi_approver = OfiApprover::where('ofi_id', $id)->get();
        if ($ofi_approver->isEmpty())
        {
            $audit_head = User::where('role_id',4)->first();
            if ($ofi->department_id == 2)
            {
                $approver_array = [
                    $ofi->issued_to,
                    $ofi->issued_by
                ];
            }
            else
            {
                $approver_array = [
                    $ofi->issued_to,
                    $ofi->issued_by,
                    $audit_head->id,
                ];
            }
            
            if ($ofi->department_id == 2)
            {
                $users = User::whereIn('id', $approver_array)->orderBy('role_id','desc')->get();
            }
            else
            {
                $users = User::whereIn('id', $approver_array)->orderBy('level','asc')->get();
            }
            
            foreach($users as $key=>$user)
            {
                $ofi_approver = new OfiApprover;
                $ofi_approver->user_id = $user->id;
                $ofi_approver->ofi_id = $id;
                $ofi_approver->level = $key+1;
                if ($key == 0)
                {
                    $ofi_approver->status = 'Submitted';
                }
                elseif($key==1)
                {
                    $ofi_approver->status = 'Pending';
                }
                else
                {
                    $ofi_approver->status = 'Waiting';
                }
                $ofi_approver->save();
            }
        }
        else
        {
            foreach($ofi_approver as $key=>$approver)
            {
                if ($key == 0)
                {
                    $approver->status = 'Submitted';
                }
                elseif($key==1)
                {
                    $approver->status = 'Pending';
                }
                else
                {
                    $approver->status = 'Waiting';
                }
                $approver->save();
            }
        }

        // $auditHead = User::whereNull('status')->where('role_id', 4)->first();
        // $ofi_verifiers = [
        //     $ofi->issuedTo,
        //     $ofi->issuedBy,
        //     $auditHead
        // ];
        // $ofi_verifier = OfiVerifier::where('ofi_id', $id)->delete();
        // foreach($ofi_verifiers as $key=>$verifier)
        // {
        //     $verifiers = new OfiVerifier;
        //     $verifiers->ofi_id = $id;
        //     $verifiers->level = $key+1;
        //     $verifiers->user_id = $verifier->id;
        //     if ($key == 0)
        //     {
        //         $verifiers->status = "Submitted";
        //     }
        //     elseif($key == 1)
        //     {
        //         $verifiers->status = "Pending";
        //     }
        //     else 
        //     {
        //         $verifiers->status = "Waiting";
        //     }
        //     $verifiers->save();
        // }

        Alert::success('Successfully Saved')->persistent("Dismiss");
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

    public function verify(Request $request, $id)
    {
        // dd($request->all(), $id);
        $ofi = Ofi::findOrFail($id);
        $ofi->status = 'For Verification';
        // if ($request->has('ofi_verify'))
        // {
        //     $ofi->immediate_action = $request->ofi_verify;
        //     $ofi->action_date_immediate_action = $request->ofi_verify_date;
        // }
        $ofi->save();

        // if ($request->has('corrective_action'))
        // {
        //     $corrective_actions = CorrectiveAction::where('corrective_action_request_id', $id)->get();
        //     foreach($corrective_actions as $key=>$corrective_action)
        //     {
        //         // $corrective_action = new CorrectiveAction;
        //         $corrective_action->corrective_action_request_id = $id;
        //         $corrective_action->corrective_action = $request->corrective_action[$key];
        //         $corrective_action->action_date = $request->action_date[$key];
        //         $corrective_action->save();
        //     }
        // }
        
        $audit_head = User::whereNull('status')->where('role_id', 4)->first();
        $auditor = $ofi->issued_by;
        if($ofi->department_id == 2)
        {
            $verifier_array = [
                $ofi->issued_to,
                $auditor
            ];
        }
        else
        {
            $verifier_array = [
                $ofi->issued_to,
                $auditor,
                $audit_head->id
            ];
        }

        $verify = OfiVerifier::where('ofi_id', $id)->orderBy('level','asc')->get();
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
            if($ofi->department_id == 2)
            {
                $users = User::whereIn('id', $verifier_array)->orderBy('role_id','desc')->get();
            }
            else
            {
                $users = User::whereIn('id', $verifier_array)->orderBy('level','asc')->get();
            }
            foreach($users as $key=>$user)
            {
                $ofi_verifier = new OfiVerifier;
                $ofi_verifier->ofi_id = $id;
                $ofi_verifier->user_id = $user->id;
                $ofi_verifier->level = $key+1;
    
                if ($key == 0)
                {
                    $ofi_verifier->status = 'Submitted';
                }
                elseif($key==1)
                {
                    $ofi_verifier->status = 'Pending';
                }
                else
                {
                    $ofi_verifier->status = 'Waiting';
                }
    
                $ofi_verifier->save();
            }
    
            Alert::success('Successfully Saved')->persistent('Dismiss');
            return back();
        }
    }

    public function updateOfiVerify(Request $request,$id)
    {

        $ofi = OfiImmediateAction::findMany($request->immediate_action_id);
        foreach($ofi as $key=>$ofi_verify)
        {
            $ofi_verify->status = $request->immediate_action_status[$key];
            $ofi_verify->remarks = $request->immediate_action_remarks[$key];
            $ofi_verify->date_approved = date('Y-m-d');

            if (isset($request->immediate_action_file[$key]))
            {
                $files = $request->file('immediate_action_file')[$key];
                $name = time().'_'.$files->getClientOriginalName();
                $files->move(public_path('immediate_action_file'), $name);
                $ofi_verify->attachments = '/immediate_action_file/'.$name;
            }

            $ofi_verify->save();
        }

        foreach($request->immediate_action_status as $key=>$status)
        {
            $remarks_history = new OfiRemarksHistory;
            $remarks_history->ofi_id = $id;
            $remarks_history->status =  $status;
            $remarks_history->remarks = $request->immediate_action_remarks[$key];
            $remarks_history->immediate_action_id = $request->immediate_action_id[$key];
            $remarks_history->save();
        }

        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }
}
