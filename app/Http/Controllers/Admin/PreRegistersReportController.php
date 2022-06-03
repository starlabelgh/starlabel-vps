<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\PreRegister;
use Illuminate\Http\Request;

class PreRegistersReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'PreRegisters Report';

        $this->middleware(['permission:admin-pre-registers-report'])->only('index');
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
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if (!blank($dateBetween)) {
                $this->data['preRegisters'] = PreRegister::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->orderBy('id', 'DESC')->get();
            } else {
                $this->data['preRegisters'] = PreRegister::orderBy('id', 'DESC')->get();
            }
        }
        return view('admin.report.pre-register.index', $this->data);
    }
}
