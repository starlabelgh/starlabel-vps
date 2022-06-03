<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Enums\Status;
use App\Enums\VisitorStatus;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use App\Models\Visitor;
use App\Models\Employee;
use Illuminate\Support\Env;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitingDetails;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\VisitorConfirmation;
use App\Http\Services\Visitor\VisitorService;

class VisitorController extends Controller
{
    protected $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;

        $this->middleware('auth');
        $this->data['sitetitle'] = 'Visitors';

        $this->middleware(['permission:visitors'])->only('index');
        $this->middleware(['permission:visitors_create'])->only('create', 'store');
        $this->middleware(['permission:visitors_edit'])->only('edit', 'update');
        $this->middleware(['permission:visitors_delete'])->only('destroy');
        $this->middleware(['permission:visitors_show'])->only('show');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.visitor.index');
    }


    public function create(Request $request)
    {

        $this->data['employees'] = Employee::where('status', Status::ACTIVE)->get();

        return view('admin.visitor.create', $this->data);
    }

    public function store(VisitorRequest $request)
    {
        $this->visitorService->make($request);
        return redirect()->route('admin.visitors.index')->withSuccess('The data inserted successfully!');
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
        $this->data['visitingDetails'] = $this->visitorService->find($id);
        if ($this->data['visitingDetails']) {
            return view('admin.visitor.show', $this->data);
        } else {
            return redirect()->route('admin.visitors.index');
        }
    }
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visitorID' => 'required|numeric',
        ], [
            'visitorID.required' => 'Visitor ID required',
            'visitorID.numeric' => 'ID must be numeric'
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.visitors.index'))->withError($validator->errors()->first('visitorID'));
        };

        $id = $request->visitorID;

        $visitingDetail = VisitingDetails::where('reg_no', $id)->first();
        if ($visitingDetail && (!$visitingDetail->checkout_at)) {
            $visitingDetail->checkout_at = date('y-m-d H:i');
            $visitingDetail->save();
            return redirect()->route('admin.visitors.index')->withSuccess('Successfully Checked-Out!');
        } elseif (!$visitingDetail) {
            return redirect()->route('admin.visitors.index')->withError('ID not found');
        } else {

            return redirect()->route('admin.visitors.index')->withError('Already Checked-Out!');
        }
    }

    public function edit($id)
    {
        $this->data['employees'] = Employee::where('status', Status::ACTIVE)->get();
        $this->data['visitingDetails'] = $this->visitorService->find($id);
        if ($this->data['visitingDetails']) {
            return view('admin.visitor.edit', $this->data);
        } else {
            return redirect()->route('admin.visitors.index');
        }
    }

    public function update(VisitorRequest $request, VisitingDetails $visitor)
    {
        $this->visitorService->update($request, $visitor->id);
        return redirect()->route('admin.visitors.index')->withSuccess('The data updated successfully!');
    }

    public function destroy($id)
    {
        $this->visitorService->delete($id);
        return redirect()->route('admin.visitors.index')->withSuccess('The data delete successfully!');
    }


    public function getVisitor(Request $request)
    {
        $visitingDetails = $this->visitorService->all();
        $i            = 1;
        $visitingDetailArray = [];
        if (!blank($visitingDetails)) {
            foreach ($visitingDetails as $visitingDetail) {
                $visitingDetailArray[$i]          = $visitingDetail;
                $visitingDetailArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($visitingDetailArray)
            ->addColumn('action', function ($visitingDetail) {
                $retAction = '';

                if ((auth()->user()->can('visitors_show')) && (!$visitingDetail->checkout_at)) {
                    $retAction .= '<a href="' . route('admin.visitors.checkout', $visitingDetail) . '" class="btn btn-sm btn-icon mr-1  float-left btn-success" data-toggle="tooltip" data-placement="top" title="Check-Out"><i class="fas fa-sign-out-alt"></i></a>';
                }

                if (auth()->user()->can('visitors_show')) {
                    $retAction .= '<a href="' . route('admin.visitors.show', $visitingDetail) . '" class="btn btn-sm btn-icon mr-1  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('visitors_edit')) {
                    $retAction .= '<a href="' . route('admin.visitors.edit', $visitingDetail) . '" class="btn btn-sm btn-icon mr-1 float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }


                if (auth()->user()->can('visitors_delete')) {
                    $retAction .= '<form class="float-left  " action="' . route('admin.visitors.destroy', $visitingDetail) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })

            ->editColumn('name', function ($visitingDetail) {
                return Str::limit(optional($visitingDetail->visitor)->name, 50);
            })
            ->addColumn('image', function ($visitingDetail) {
                return '<figure class="avatar mr-2"><img src="' . $visitingDetail->images . '" alt=""></figure>';
            })
            ->editColumn('visitor_id', function ($visitingDetail) {
                return $visitingDetail->reg_no;
            })

            ->editColumn('phone', function ($visitingDetail) {
                return Str::limit(optional($visitingDetail->visitor)->phone, 50);
            })
            ->editColumn('employee_id', function ($visitingDetail) {
                return optional($visitingDetail->employee->user)->name;
            })
            ->editColumn('status', function ($visitingDetail) {
                $drop = '';
                $dropActive = false;
                $activeStatus = 'Change Status';
                foreach (trans("visitor_statuses") as $key => $status) {
                    if ($visitingDetail->status == $key) {
                        $activeStatus = $status;
                    }

                    if ($visitingDetail->status != VisitorStatus::ACCEPT && $key != $visitingDetail->status) {
                        if ($visitingDetail->status == VisitorStatus::REJECT) {
                            $dropActive = false;
                        } else {
                            $drop .= '<a class="dropdown-item" href="' . route('admin.visitor.change-status', [$visitingDetail->id, $key]) . '" >' . $status . '</a>';
                            $dropActive = true;
                        }
                    }
                }
                if ($dropActive) {
                    return '<div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                        . $activeStatus
                        . '</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' . $drop . '</div></div>';
                } else {
                    return '<span class="badge ' . ($visitingDetail->status == VisitorStatus::ACCEPT ? 'badge-success' : 'badge-danger') . '">' . $activeStatus . '</span>';
                }
            })
            ->editColumn('date', function ($visitingDetail) {
                if ($visitingDetail->checkin_at) {
                    return date('d-M-Y h:i A', strtotime($visitingDetail->checkin_at));
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('checkout', function ($visitingDetail) {
                if ($visitingDetail->checkout_at) {
                    return date('d-M-Y h:i A', strtotime($visitingDetail->checkout_at));
                } else {
                    return 'N/A';
                }
            })

            ->editColumn('id', function ($visitingDetail) {
                return $visitingDetail->setID;
            })
            ->rawColumns(['name', 'action'])
            ->escapeColumns([])
            ->make(true);
    }
    public function checkout(VisitingDetails $visitingDetail)
    {

        $visitingDetail->checkout_at = date('y-m-d H:i');
        $visitingDetail->save();
        return redirect()->route('admin.visitors.index')->withSuccess('Successfully Check-Out!');
    }

    public function changeStatus($id, $status)
    {
        $visitor         = VisitingDetails::findOrFail($id);
        $visitor->status = $status;
        $visitor->checkin_at = date('y-m-d H:i');
        $visitor->save();
        try {
            $visitor->visitor->notify(new VisitorConfirmation($visitor));
            return redirect()->route('admin.visitors.index')->withSuccess('The Status Change successfully!');
        } catch (\Exception $e) {
        }
    }
}
