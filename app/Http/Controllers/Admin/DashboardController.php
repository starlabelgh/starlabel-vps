<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\PreRegister;
use App\Models\VisitingDetails;
use App\Models\Visitor;


class DashboardController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sitetitle'] = 'Dashboard';
        $this->middleware(['permission:dashboard'])->only('index');
    }
    public function index()
    {
        if (auth()->user()->getrole->name == 'Employee') {
            $visitors       = VisitingDetails::where(['employee_id' => auth()->user()->employee->id])->orderBy('id', 'desc')->get();
            $preregister    = PreRegister::where(['employee_id' => auth()->user()->employee->id])->orderBy('id', 'desc')->get();
            $totalEmployees = 0;
        } else {
            $visitors       = VisitingDetails::orderBy('id', 'desc')->get();
            $preregister    = PreRegister::orderBy('id', 'desc')->get();
            $employees      = Employee::orderBy('id', 'desc')->get();
            $totalEmployees = count($employees);
        }

        $totalVisitor   = count($visitors);
        $totalPrerigister = count($preregister);

        $attendance = Attendance::where(['user_id' => auth()->user()->id, 'date' => date('Y-m-d')])->first();
        $this->data['attendance']    = $attendance;
        $this->data['totalVisitor']    = $totalVisitor;
        $this->data['totalEmployees'] = $totalEmployees;
        $this->data['totalPrerigister']     = $totalPrerigister;
        $this->data['visitors']  = $visitors;

        return view('admin.dashboard.index', $this->data);
    }
}
