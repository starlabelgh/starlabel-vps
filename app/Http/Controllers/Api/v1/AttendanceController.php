<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Attendance;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AttendanceResource;
use App\Http\Resources\v1\SingleVisitorResource;
use Attribute;

class AttendanceController extends Controller
{
    use ApiResponse;



    public function __construct()
    {
        $this->data['siteTitle'] = 'Attendance';
        $this->middleware('auth:api');
        $this->middleware(['permission:attendance'])->only('index');
        $this->middleware(['permission:attendance_delete'])->only('destroy');
    }
    public function index($date = null)
    {
        try {
            if (!blank($date)) {
                $attendances = Attendance::where(['date' => date('Y-m-d', strtotime($date))])->get();
            } else {
                $attendances = Attendance::orderBy('id', 'desc')->get();
            }
            $i            = 1;
            $employees = [];
            if (!blank($attendances)) {
                foreach ($attendances as $attendance) {
                    $employees[$i]['id'] = $attendance->id;
                    $employees[$i]['name'] = $attendance->user->name;
                    $employees[$i]['checkin_time'] = $attendance->checkin_time;
                    $employees[$i]['checkout_time'] = $attendance->checkout_time;
                    $employees[$i]['image'] = $attendance->user->images;
                    $i++;
                }
                $attendanceList = AttendanceResource::collection($employees);
                return $this->successResponse(['status' => 200, 'data' => $attendanceList]);
            } else {
                return response()->json([
                    'status'  => 401,
                    'message' => 'The data not found',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }
    public function getStatus()
    {
        $user = auth()->user();
        $show_clockin = true;
        $attendance = Attendance::where(['user_id' => $user->id, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->first();
        if ($attendance) {
            if (!blank($attendance->checkout_time)) {
                $show_clockin = false;
            }
        } else {
            $show_clockin = true;
        }

        $employee = new SingleVisitorResource($user);

        return $this->successResponse(['status' => 200, 'employee' => $employee, 'show_clockin' => $show_clockin]);
    }

    public function clockIn(Request $request)
    {
        $request->validate([
            'title' => 'nullable|max:100',
        ]);
        $attendance = new Attendance;
        $attendance->title = $request->title ?? 'Office';
        $attendance->checkin_time = date('g:i A');
        $attendance->date = date('Y-m-d');
        $attendance->user_id = auth()->user()->id;
        $attendance->save();
        return $this->successResponse(['status' => 200, 'message' => 'Clocked In Successfully']);
    }

    public function clockOut()
    {
        $attendance = Attendance::where(['user_id' => auth()->user()->id, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->first();
        if ($attendance) {
            $attendance->checkout_time     = date('g:i A');
            $attendance->user_id         = auth()->user()->id;
            $attendance->save();
        }

        return $this->successResponse(['status' => 200, 'message' => 'Checked Out Successfully']);
    }
}
