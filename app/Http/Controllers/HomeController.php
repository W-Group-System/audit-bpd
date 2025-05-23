<?php

namespace App\Http\Controllers;

use App\CorrectiveActionRequest;
use App\Department;
use Illuminate\Http\Request;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cars = CorrectiveActionRequest::get();
        $departments = Department::get();
        if (auth()->user()->role->name == 'Auditee')
        {
            $cars = CorrectiveActionRequest::where('department_id', auth()->user()->department_id)->get();
            $departments = Department::where('id', auth()->user()->department_id)->get();
        }
        $car_per_dept_array = [];
        foreach($departments as $department)
        {
            $object = new stdClass;
            // $car = CorrectiveActionRequest::get();
            
            $object->dept_id = $department->id;
            $object->department = $department->code .' - '.$department->name;
            $object->open = count($cars->where('status', '!=', 'Closed')->where('department_id', $department->id));
            // $object->in_progress = count($car->where('status', 'In Progress')->where('department_id', $department->id));
            $object->closed = count($cars->where('status', 'Closed')->where('department_id', $department->id));
            $object->open_cars = $cars->where('status', '!=', 'Closed')->where('department_id', $department->id);
            $object->closed_cars = $cars->where('status', 'Closed')->where('department_id', $department->id);
            $car_per_dept_array[] = $object;
        }

        return view('home', compact('cars', 'car_per_dept_array'));
    }
}
