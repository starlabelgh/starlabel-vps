<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\VisitingDetails;
use Illuminate\Http\Request;

class VisitorReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Visitor Report';

        $this->middleware(['permission:admin-visitor-report'])->only('index');
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
                $this->data['visitors'] = VisitingDetails::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->orderBy('id', 'DESC')->get();
            } else {
                $this->data['visitors'] = VisitingDetails::orderBy('id', 'DESC')->get();
            }
            $this->data['totalVisitor'] = 0;
            $this->data['checkinVisitor'] = 0;
            $this->data['checkoutVisitor'] = 0;
            if(!blank($this->data['visitors'])){
                $checkin = 0;
                $checkout = 0;
                foreach ($this->data['visitors'] as $visitor){
                        if($visitor->checkin_at){
                            $checkin +=1;
                        }
                        if($visitor->checkout_at){
                            $checkout +=1;
                        }
                }
                $this->data['totalVisitor'] = count($this->data['visitors']);
                $this->data['checkinVisitor'] = $checkin;
                $this->data['checkoutVisitor'] = $checkout;
            }

        }
        return view('admin.report.visitor.index', $this->data);
    }
}
