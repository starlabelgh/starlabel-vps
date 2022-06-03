<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\Attendance;
use App\Models\VisitingDetails;
use Illuminate\Http\Request;

class AttendanceReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Attendance Report';
        $this->middleware(['permission:attendance-report'])->only('index');
    }

    public function index(Request $request)
    {
        $this->data['showView']      = false;
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';

        if ($_POST) {
            $request->validate([
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            $this->data['showView']      = true;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date));
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date));
            }

            if (!blank($dateBetween)) {
                $this->data['attendances'] = Attendance::whereBetween('date', [$dateBetween['from_date'], $dateBetween['to_date']])->orderBy('id', 'DESC')->get();
            } else {
                $this->data['attendances'] = Attendance::orderBy('id', 'DESC')->get();
            }
        }
        return view('admin.report.attendance.index', $this->data);
    }
}
