<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('company', 'department', 'role')->get();
        $companies = Company::whereNull('status')->get();
        $departments = Department::whereNull('status')->get();
        $roles = Role::whereNull('status')->get();
        
        return view('users.index', compact('users', 'companies', 'departments', 'roles'));
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
        $this->validate($request, [
            'email' => 'unique:users,email'
        ]);

        $users = new User;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->company_id = $request->company;
        $users->department_id = $request->department;
        $users->role_id = $request->role;
        $users->password = bcrypt('abc123');
        if ($request->role == 1)
        {
            // Auditor
            $users->level = 2;
        }
        elseif($request->role == 2)
        {
            // Auditee
            $users->level = 1;
        }
        elseif($request->role == 4)
        {
            // Audit Heads
            $users->level = 3;
        }
        $users->save();

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
        $this->validate($request, [
            'email' => 'unique:users,email,'.$id
        ]);

        $users = User::findOrFail($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->company_id = $request->company;
        $users->department_id = $request->department;
        $users->role_id = $request->role;
        // $users->password = bcrypt('abc123');
        $users->save();

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

    public function deactivate(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = 'deactivate';
        $user->save();

        // Alert::success('Successfully Deactivated')->persistent('Dismiss');
        // return back();
    }

    public function activate(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = null;
        $user->save();

        // Alert::success('Successfully Activated')->persistent('Dismiss');
        // return back();
    }
}
