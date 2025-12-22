<?php

namespace App\Http\Controllers;

use App\Department;
use App\Ofi;
use App\OfiAttachment;
use App\OfiVerifier;
use App\User;
use Illuminate\Http\Request;
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
        $ofis = Ofi::with('department','issuedBy','issuedTo')->get();
        $departments = Department::with('dept_head')->whereNull('status')->get();
        $users = User::whereNull('status')->get();

        if (auth()->user()->role->name == "Auditee")
        {
            $ofis = Ofi::with('department','issuedBy','issuedTo')->where('issued_to', auth()->user()->id)->get();
        }

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
        // dd($request->all());
        $ofi = new Ofi;
        $ofi->department_id = $request->department;
        $ofi->issued_by = $request->auditor;
        $ofi->issued_to = $request->auditee;
        $ofi->recommendation = $request->recommendation;
        $ofi->status = "Pending";
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
        $ofi->action_date = $request->action_date;
        $ofi->save();
        
        $ofi_attachment = OfiAttachment::where('ofi_id', $id)->delete();
        $files = $request->file('files');
        foreach($files as $file)
        {
            $name = time()."_".$file->getClientOriginalName();
            $file->move(public_path('ofi_attachments'),$name);
            $attachment = '/ofi_attachments/'.$name;

            $ofi_attachment = new OfiAttachment;
            $ofi_attachment->ofi_id = $id;
            $ofi_attachment->attachment = $attachment;
            $ofi_attachment->save();
        }

        $auditHead = User::whereNull('status')->where('role_id', 4)->first();
        $ofi_verifiers = [
            $ofi->issuedTo,
            $ofi->issuedBy,
            $auditHead
        ];
        $ofi_verifier = OfiVerifier::where('ofi_id', $id)->delete();
        foreach($ofi_verifiers as $key=>$verifier)
        {
            $verifiers = new OfiVerifier;
            $verifiers->ofi_id = $id;
            $verifiers->level = $key+1;
            $verifiers->user_id = $verifier->id;
            if ($key == 0)
            {
                $verifiers->status = "Submitted";
            }
            elseif($key == 1)
            {
                $verifiers->status = "Pending";
            }
            else 
            {
                $verifiers->status = "Waiting";
            }
            $verifiers->save();
        }

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
}
