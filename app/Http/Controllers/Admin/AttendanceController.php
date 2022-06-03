<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AttendanceController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Attendance';
        $this->middleware(['permission:attendance'])->only('index');
        $this->middleware(['permission:attendance_delete'])->only('destroy');
//
    }


    public function index(Request $request)
    {
        $attendance = Attendance::where(['user_id'=>auth()->user()->id,'date'=>date('Y-m-d')])->first();

        return view('admin.attendance.index',compact('attendance'));
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete($id);
        return redirect()->route('admin.attendance.index')->withSuccess('The data delete successfully!');
    }
    public function getAttendance(Request $request)
    {
        $attendances = Attendance::orderBy('id', 'desc')->get();
        $i            = 1;
        $attendanceArray = [];
        if (!blank($attendances)) {
            foreach ($attendances as $attendance) {
                $attendanceArray[$i]          = $attendance;
                $attendanceArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($attendanceArray)
            ->addColumn('action', function ($attendance) {
                $retAction = '';

                if (auth()->user()->can('attendance_delete')) {
                    $retAction .= '<form class="float-left  " action="' . route('admin.attendance.destroy', $attendance) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })

            ->editColumn('user', function ($attendance) {
                return Str::limit(optional($attendance->user)->name, 50);
            })
            ->editColumn('working', function ($attendance) {
                return Str::limit($attendance->title, 30);
            })
            ->addColumn('image', function ($attendance) {
                return '<figure class="avatar mr-2"><img src="' . optional($attendance->user)->images . '" alt=""></figure>';
            })

            ->editColumn('date', function ($attendance) {
                return date('d-m-Y', strtotime($attendance->date));
            })
            ->addColumn('clockin', function ($attendance) {
                if ($attendance->checkin_time) {
                    return $attendance->checkin_time;
                } else {
                    return 'N/A';
                }
            })
            ->addColumn('clockout', function ($attendance) {
                if ($attendance->checkout_time) {
                    return $attendance->checkout_time;
                } else {
                    return 'N/A';
                }
            })

            ->editColumn('id', function ($attendance) {
                return $attendance->setID;
            })
            ->rawColumns(['name', 'action'])
            ->escapeColumns([])
            ->make(true);
    }


    public function clockIn(Request $request)
    {
        $request->validate([
            'title' =>'nullable|max:100',
        ]);
        $attendance = new Attendance;
        $attendance->title = $request->title??'Office';
        $attendance->checkin_time = date('g:i A');
        $attendance->date = date('Y-m-d');
        $attendance->user_id = auth()->user()->id;
        $attendance->save();
        return redirect()->back()->with('success','Attendance successfully');
    }

    public function clockOut(Request $request)
    {
        $attendance = Attendance::where(['user_id'=>auth()->user()->id,'date'=>date('Y-m-d')])->first();
        if($attendance){
            $attendance->checkout_time	 = date('g:i A');
            $attendance->user_id         = auth()->user()->id;
            $attendance->save();
        }

        return redirect()->back()->with('success','Clock-out successfully');
    }
}
