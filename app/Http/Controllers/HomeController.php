<?php

namespace App\Http\Controllers;

use App\CorrectiveActionRequest;
use App\Department;
use App\RootCauseAnalysis;
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
    public function index(Request $reques)
    {
        $year = request('year');

        $carsQuery = CorrectiveActionRequest::query();
        $rcaQuery = RootCauseAnalysis::with('corrective_action_request');
        $departmentsQuery = Department::whereNull('status');

        if (auth()->user()->role->name == 'Auditee')
        {
            $carsQuery->where('department_id', auth()->user()->department_id)->get();
            $departmentsQuery->where('id', auth()->user()->department_id)->get();
        }

        if ($year) {
            $carsQuery->whereYear('created_at', $year);
            $rcaQuery->whereHas('corrective_action_request', function ($q) use ($year) {
                $q->whereYear('created_at', $year);
            });
        }

        $cars = $carsQuery->get();
        $rca = $rcaQuery->get();
        $departments = $departmentsQuery->get();
        
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
            $object->delayed = $cars->filter(function ($car) use ($department) {
                if ($car->status == 'Closed') {
                    return false;
                }

                if ($car->department_id != $department->id) {
                    return false;
                }

                $hasDelayedCorrective = $car->correctiveAction->contains(function ($action) {
                    return empty($action->file_attachments)
                        && $action->action_date < now();
                });

                $hasDelayedImmediate = $car->correctionImmediateAction->contains(function ($action) {
                    return empty($action->attachments)
                        && $action->correction_action_date < now();
                });

                return $hasDelayedCorrective || $hasDelayedImmediate;

            })->count();
            $car_per_dept_array[] = $object;
            $object->delayed_cars = $cars->filter(function ($car) use ($department) {
                if ($car->status == 'Closed') {
                    return false;
                }

                if ($car->department_id != $department->id) {
                    return false;
                }

                $hasDelayedCorrective = $car->correctiveAction->contains(function ($action) {
                    return empty($action->file_attachments)
                        && $action->action_date < now();
                });

                $hasDelayedImmediate = $car->correctionImmediateAction->contains(function ($action) {
                    return empty($action->attachments)
                        && $action->correction_action_date < now();
                });

                return $hasDelayedCorrective || $hasDelayedImmediate;
            });

        }
        
        return view('home', compact('cars', 'car_per_dept_array', 'rca'));
    }
}
