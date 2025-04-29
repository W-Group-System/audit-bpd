<?php

namespace App\Http\Controllers;

use App\CorrectiveActionRequest;
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
        $corrective_action_requests = CorrectiveActionRequest::get();

        return view('car.index', compact('users', 'corrective_action_requests'));
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
        $car = new CorrectiveActionRequest;
        $car->standard_and_clause = $request->standard_and_clause;
        $car->classification_of_nonconformity = $request->classification_of_nonconformity;
        $car->nature_of_nonconformity = $request->nature_of_nonconformity;
        $car->type_of_nonconformity = $request->type_of_nonconformity;
        $car->auditor_id = $request->auditor;
        $car->auditee_id = $request->auditee;
        $car->reference_document = $request->reference_document;
        $car->description_of_nonconformity = $request->description_of_nonconformity;
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
        //
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
