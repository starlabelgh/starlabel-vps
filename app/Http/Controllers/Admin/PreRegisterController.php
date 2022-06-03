<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\PreRegisterRequest;
use App\Models\Employee;
use App\Models\PreRegister;
use App\Models\Visitor;
use App\Http\Services\PreRegister\PreRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PreRegisterController extends Controller
{
    protected $preRegisterService;

    public function __construct(PreRegisterService $preRegisterService)
    {
        $this->preRegisterService = $preRegisterService;

        $this->middleware('auth');
        $this->data['sitetitle'] = 'Pre-registers';
        $this->middleware(['permission:pre-registers'])->only('index');
        $this->middleware(['permission:pre-registers_create'])->only('create', 'store');
        $this->middleware(['permission:pre-registers_edit'])->only('edit', 'update');
        $this->middleware(['permission:pre-registers_delete'])->only('destroy');
        $this->middleware(['permission:pre-registers_show'])->only('show');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        return view('admin.pre-register.index');
    }

    public function create(Request $request)
    {
        if(auth()->user()->getrole->name == 'Employee') {
            $this->data['employees'] = Employee::where(['status'=>Status::ACTIVE,'id'=>auth()->user()->employee->id])->get();
        }else {
            $this->data['employees'] = Employee::where('status', Status::ACTIVE)->get();
        }

        return view('admin.pre-register.create', $this->data);
    }

    public function store(PreRegisterRequest $request)
    {
        $this->preRegisterService->make($request);
        return redirect()->route('admin.pre-registers.index')->withSuccess('The data inserted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $this->data['preregister'] = $this->preRegisterService->find($id);
        if($this->data['preregister']){
            return view('admin.pre-register.show', $this->data);
        }else {
            return redirect()->route('admin.pre-registers.index');
        }
    }

    public function edit($id)
    {
        if(auth()->user()->getrole->name == 'Employee') {
            $this->data['employees'] = Employee::where(['status'=>Status::ACTIVE,'id'=>auth()->user()->employee->id])->get();
        }else {
            $this->data['employees'] = Employee::where('status', Status::ACTIVE)->get();
        }
        $this->data['preregister'] = $this->preRegisterService->find($id);
        if($this->data['preregister']){
            return view('admin.pre-register.edit', $this->data);
        }else {
            return redirect()->route('admin.pre-registers.index');
        }
    }

    public function update(PreRegisterRequest $request,PreRegister $preRegister)
    {
        $this->preRegisterService->update($request,$preRegister->id);
        return redirect()->route('admin.pre-registers.index')->withSuccess('The data updated successfully!');
    }

    public function destroy($id)
    {
        $this->preRegisterService->delete($id);
        return redirect()->route('admin.pre-registers.index')->withSuccess('The data delete successfully!');
    }


    public function getPreRegister(Request $request)
    {
        $pre_registers = $this->preRegisterService->all($request);
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
                $retAction ='';

                if(auth()->user()->can('pre-registers_show')) {
                    $retAction .= '<a href="' . route('admin.pre-registers.show', $pre_register) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if(auth()->user()->can('pre-registers_edit')) {
                    $retAction .= '<a href="' . route('admin.pre-registers.edit', $pre_register) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }


                if(auth()->user()->can('pre-registers_delete')) {
                    $retAction .= '<form class="float-left pl-2" action="' . route('admin.pre-registers.destroy', $pre_register). '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
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
            ->editColumn('employee_id', function ($pre_register) {
                return optional($pre_register->employee->user)->name;
            })
            ->editColumn('expected_date', function ($pre_register) {
                if (optional($pre_register->visitor)->is_pre_register==1){
                    $date = '<p class="text-danger">' . $pre_register->expected_date . '</p>';
                }else{
                    $date = '<p>' . $pre_register->expected_date . '</p>';
                }
                return $date;
            })
            ->editColumn('expected_time', function ($pre_register) {
                if (optional($pre_register->visitor)->is_pre_register==1) {
                    $time = '<p class="text-danger">' . date('h:i A', strtotime($pre_register->expected_time)) . '</p>';
                }else {
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
