<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingDateRequest;
use App\Http\Requests\EmployeeChekinRequest;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Attendance;
use App\Models\Booking;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\PreRegister;
use App\Models\VisitingDetails;
use App\Models\Visitor;
use App\Notifications\SendInvitationToVisitors;
use App\Http\Services\Booking\BookingService;
use App\Http\Services\Employee\EmployeeService;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{
    protected $employeeService;
    protected $bookingService;

    public function __construct(EmployeeService $employeeService, BookingService $bookingService)
    {
        $this->employeeService = $employeeService;
        $this->bookingService = $bookingService;
        $this->middleware('auth');
        $this->data['sitetitle'] = 'Employees';

        $this->middleware(['permission:employees'])->only('index');
        $this->middleware(['permission:employees_create'])->only('create', 'store');
        $this->middleware(['permission:employees_edit'])->only('edit', 'update');
        $this->middleware(['permission:employees_delete'])->only('destroy');
        $this->middleware(['permission:employees_show'])->only('show');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeeService->all();
        return view('admin.employee.index', $this->data);
    }

    public function create(Request $request)
    {

        $this->data['designations'] = Designation::where('status', Status::ACTIVE)->get();
        $this->data['departments'] = Department::where('status', Status::ACTIVE)->get();

        return view('admin.employee.create', $this->data);
    }

    public function store(EmployeeRequest $request)
    {
        $this->employeeService->make($request);
        return redirect()->route('admin.employees.index')->withSuccess('The data inserted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $this->data['employee'] = $this->employeeService->find($id);
        return view('admin.employee.show', $this->data);
    }

    public function edit($id)
    {
        $this->data['employee'] = $this->employeeService->find($id);
        $this->data['designations'] = Designation::where('status', Status::ACTIVE)->get();
        $this->data['departments'] = Department::where('status', Status::ACTIVE)->get();
        return view('admin.employee.edit', $this->data);
    }
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $this->employeeService->update($employee->id, $request);
        return redirect()->route('admin.employees.index')->withSuccess('The data updated successfully!');
    }


    public function checkEmployee(EmployeeChekinRequest $request, $id)
    {
        $this->employeeService->check($id, $request);
        return back()->with(['success' => 'Employee Checkin updated successfully.']);
    }

    public function destroy($id)
    {
        $this->employeeService->delete($id);
        return redirect()->route('admin.employees.index')->with(['success' => 'Employee delete successfully.']);
    }


    public function getEmployees(Request $request)
    {
        $employees = $this->employeeService->all();

        $i            = 1;
        $employeeArray = [];
        if (!blank($employees)) {
            foreach ($employees as $employee) {
                $employeeArray[$i]          = $employee;
                $employeeArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($employeeArray)
            ->addColumn('action', function ($employee) {
                $retAction = '';

                if (auth()->user()->can('employees_show')) {
                    $retAction .= '<a href="' . route('admin.employees.show', $employee) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('employees_edit')) {
                    $retAction .= '<a href="' . route('admin.employees.edit', $employee) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }


                if (auth()->user()->can('employees_delete')) {
                    $retAction .= '<form class="float-left pl-2" action="' . route('admin.employees.destroy', $employee) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })
            ->addColumn('image', function ($employee) {
                return '<figure class="avatar mr-2"><img src="' . $employee->user->images . '" alt=""></figure>';
            })
            ->editColumn('name', function ($employee) {
                return Str::limit($employee->name, 50);
            })
            ->editColumn('email', function ($employee) {
                return Str::limit(optional($employee->user)->email, 50);
            })
            ->editColumn('phone', function ($employee) {
                return Str::limit(optional($employee->user)->phone, 50);
            })
            ->editColumn('status', function ($employee) {
                return ($employee->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
            })
            ->editColumn('date_of_joining', function ($employee) {
                return $employee->date_of_joining;
            })
            ->editColumn('id', function ($employee) {
                return $employee->setID;
            })
            ->rawColumns(['name', 'action'])
            ->escapeColumns([])
            ->make(true);
    }

    public function getVisitor($id)
    {
        $visitors = VisitingDetails::where(['employee_id' => $id])->orderBy('id', 'desc')->get();

        $i            = 1;
        $visitorArray = [];
        if (!blank($visitors)) {
            foreach ($visitors as $visitor) {
                $visitorArray[$i]          = $visitor;
                $visitorArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($visitorArray)
            ->addColumn('action', function ($visitor) {
                $retAction = '';

                if (auth()->user()->can('pre-registers_show')) {
                    $retAction .= '<a href="' . route('admin.visitors.show', $visitor) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('pre-registers_edit')) {
                    $retAction .= '<a href="' . route('admin.visitors.edit', $visitor) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }


                if (auth()->user()->can('pre-registers_delete')) {
                    $retAction .= '<form class="float-left pl-2" action="' . route('admin.visitors.destroy', $visitor) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })

            ->editColumn('name', function ($visitor) {
                return Str::limit(optional($visitor->visitor)->name, 50);
            })
            ->addColumn('image', function ($visitor) {
                return '<figure class="avatar mr-2"><img src="' . $visitor->images . '" alt=""></figure>';
            })
            ->editColumn('email', function ($visitor) {
                return Str::limit(optional($visitor->visitor)->email, 50);
            })

            ->editColumn('date', function ($visitor) {
                return date('d-m-Y h:i A', strtotime($visitor->checkin_at));
            })

            ->editColumn('id', function ($visitor) {
                return $visitor->setID;
            })
            ->rawColumns(['name', 'action'])
            ->escapeColumns([])
            ->make(true);
    }

    public function getPreRegister($id)
    {

        $pre_registers = PreRegister::where(['employee_id' => $id])->orderBy('id', 'desc')->get();

        $i            = 1;
        $pre_registerArray = [];
        if (!blank($pre_registers)) {
            foreach ($pre_registers as $pre_register) {
                $pre_registerArray[$i]          = $pre_register;
                $pre_registerArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($pre_registerArray)
            ->addColumn('action', function ($pre_register) {
                $retAction = '';

                if (auth()->user()->can('pre-registers_show')) {
                    $retAction .= '<a href="' . route('admin.pre-registers.show', $pre_register) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('pre-registers_edit')) {
                    $retAction .= '<a href="' . route('admin.pre-registers.edit', $pre_register) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }


                if (auth()->user()->can('pre-registers_delete')) {
                    $retAction .= '<form class="float-left pl-2" action="' . route('admin.pre-registers.destroy', $pre_register) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })

            ->editColumn('name', function ($pre_register) {
                return Str::limit(optional($pre_register->visitor)->name, 50);
            })
            ->editColumn('email', function ($pre_register) {
                return Str::limit(optional($pre_register->visitor)->email, 50);
            })
            ->editColumn('phone', function ($pre_register) {
                return Str::limit(optional($pre_register->visitor)->phone, 50);
            })

            ->editColumn('expected_date', function ($pre_register) {
                if (optional($pre_register->visitor)->is_pre_register == 1) {
                    $date = '<p class="text-danger">' . $pre_register->expected_date . '</p>';
                } else {
                    $date = '<p>' . $pre_register->expected_date . '</p>';
                }
                return $date;
            })
            ->editColumn('expected_time', function ($pre_register) {
                if (optional($pre_register->visitor)->is_pre_register == 1) {
                    $time = '<p class="text-danger">' . date('h:i A', strtotime($pre_register->expected_time)) . '</p>';
                } else {
                    $time = '<p>' . date('h:i A', strtotime($pre_register->expected_time)) . '</p>';
                }
                return $time;
            })
            ->editColumn('id', function ($pre_register) {
                return $pre_register->setID;
            })
            ->rawColumns(['name', 'action'])
            ->escapeColumns([])
            ->make(true);
    }
}
