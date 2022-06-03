<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentsRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DepartmentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->data['sitetitle'] = 'Departments';

        $this->middleware(['permission:departments'])->only('index');
        $this->middleware(['permission:departments_create'])->only('create', 'store');
        $this->middleware(['permission:departments_edit'])->only('edit', 'update');
        $this->middleware(['permission:departments_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.department.index', $this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.department.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DepartmentsRequest $request)
    {
        $input = $request->all();
        Department::create($input);

        return redirect()->route('admin.departments.index')->with('success','Departments created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['department']  = Department::findOrFail($id);

        return view('admin.department.edit', $this->data);
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

        $this->validate($request, ['name' => 'required|string|max:255|unique:departments,name,' . $id]);
        $input = $request->all();
        $department = Department::findOrFail($id);
        $department->update($input);

        return redirect(route('admin.departments.index'))->withSuccess('The Data Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return redirect(route('admin.departments.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getDepartments(Request $request)
    {

           $departments = Department::orderBy('id', 'desc')->get();

            $i         = 1;
            $departmentArray = [];
            if (!blank($departments)) {
                foreach ($departments as $department) {
                    $departmentArray[$i]          = $department;
                    $departmentArray[$i]['name']  = Str::limit($department->name, 100);
                    $departmentArray[$i]['setID'] = $i;
                    $i++;
                }
            }
            return Datatables::of($departmentArray)
                ->addColumn('action', function ($department) {
                    $retAction = '';

                    if(auth()->user()->can('departments_edit')) {
                        $retAction .= '<a href="' . route('admin.departments.edit', $department) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if(auth()->user()->can('departments_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.departments.destroy', $department) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                    }
                    return $retAction;
                })

                ->editColumn('status', function ($department) {
                    return ($department->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })
                ->editColumn('id', function ($department) {
                    return $department->setID;
                })
                ->make(true);

    }

}
