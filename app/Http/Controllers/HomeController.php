<?php

namespace App\Http\Controllers;

use App\CorrectiveActionRequest;
use App\Department;
use App\Ofi;
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
        $ofisQuery = Ofi::query();
        $rcaQuery = RootCauseAnalysis::with('corrective_action_request');
        $departmentsQuery = Department::whereNull('status');

        if (auth()->user()->role->name == 'Auditee')
        {
            $carsQuery->where('department_id', auth()->user()->department_id)->get();
            $ofisQuery->where('department_id', auth()->user()->department_id)->get();
            $departmentsQuery->where('id', auth()->user()->department_id)->get();
        }

        if ($year) {
            $carsQuery->whereYear('created_at', $year);
            $ofisQuery->whereYear('created_at', $year);
            $rcaQuery->whereHas('corrective_action_request', function ($q) use ($year) {
                $q->whereYear('created_at', $year);
            });
        }

        $cars = $carsQuery->get();
        $ofis = $ofisQuery->get();
        $rca = $rcaQuery->get();
        $departments = $departmentsQuery->get();
        
        $car_per_dept_array = [];
        $category = request('category', 'all');
        foreach($departments as $department)
        {
            $object = new stdClass;
            // $car = CorrectiveActionRequest::get();
            
            $object->dept_id = $department->id;
            $object->department = $department->code .' - '.$department->name;
            // $object->open = count($cars->where('status', '!=', 'Closed')->where('department_id', $department->id));
            $object->open = $cars
                ->where('status', '!=', 'Closed')
                ->where('department_id', $department->id)
                ->count();

            // $object->in_progress = count($car->where('status', 'In Progress')->where('department_id', $department->id));
            // $object->closed = count($cars->where('status', 'Closed')->where('department_id', $department->id));
            $object->closed = $cars
                ->where('status', 'Closed')
                ->where('department_id', $department->id)
                ->count();
            $object->ofi_open = $ofis
                ->where('status', '!=', 'Closed')
                ->where('department_id', $department->id)
                ->count();

            $object->ofi_closed = $ofis
                ->where('status', 'Closed')
                ->where('department_id', $department->id)
                ->count();
            

            $object->open_cars = $cars->where('status', '!=', 'Closed')->where('department_id', $department->id);
            $object->closed_cars = $cars->where('status', 'Closed')->where('department_id', $department->id);
            $object->open_ofis = $ofis
                ->where('status', '!=', 'Closed')
                ->where('department_id', $department->id);

            $object->closed_ofis = $ofis
                ->where('status', 'Closed')
                ->where('department_id', $department->id);
            $object->delayed_ofis = $ofis->filter(function ($ofi) use ($department) {
                if ($ofi->status == 'Closed' || $ofi->department_id != $department->id) {
                    return false;
                }

                return $ofi->ofiImmediateAction->contains(function ($action) {
                    return empty($action->attachments)
                        && !empty($action->implementation_date)
                        && $action->implementation_date < now();
                });
            });

            // Delayed CARs
            $object->delayed_cars = $cars->filter(function ($car) use ($department) {
                if ($car->status == 'Closed' || $car->department_id != $department->id) {
                    return false;
                }

                $hasDelayedCorrective = $car->correctiveAction->contains(function ($action) {
                    return empty($action->file_attachments)
                        && !empty($action->action_date)
                        && $action->action_date < now();
                });

                $hasDelayedImmediate = $car->correctionImmediateAction->contains(function ($action) {
                    return empty($action->attachments)
                        && !empty($action->correction_action_date)
                        && $action->correction_action_date < now();
                });

                return $hasDelayedCorrective || $hasDelayedImmediate;
            });

            $object->delayed = $object->delayed_cars->count();
            $object->ofi_delayed = $object->delayed_ofis->count();

            if ($category == 'car') {
                $object->display_open = $object->open;
                $object->display_closed = $object->closed;
                $object->display_delayed = $object->delayed ?? 0;
            } elseif ($category == 'ofi') {
                $object->display_open = $object->ofi_open;
                $object->display_closed = $object->ofi_closed;
                $object->display_delayed = 0;
            } else {
                $object->display_open = $object->open + $object->ofi_open;
                $object->display_closed = $object->closed + $object->ofi_closed;
                $object->display_delayed = $object->delayed ?? 0;
            }
            $car_per_dept_array[] = $object;
        }
        
        return view('home', compact('cars', 'ofis', 'car_per_dept_array', 'rca', 'category'));
    }
}
