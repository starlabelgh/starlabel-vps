<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Visitor;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\VisitingDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\v1\VisitorResource;
use App\Notifications\VisitorConfirmation;
use App\Http\Requests\VisitorUpdateRequest;
use App\Http\Services\Visitor\VisitorService;
use App\Http\Resources\v1\SingleVisitorResource;


class VisitorController extends Controller
{
    use ApiResponse;

    protected $visitorService;


    public function __construct(VisitorService $visitorService)
    {
        $this->data['sitetitle'] = 'Visitors';

        $this->middleware('auth:api')->except('checkin', 'checkout', 'find_visitor');
        $this->middleware(['permission:visitors'])->only('index');
        $this->middleware(['permission:visitors_create'])->only('create', 'store');
        $this->middleware(['permission:visitors_edit'])->only('edit', 'update');
        $this->middleware(['permission:visitors_delete'])->only('destroy');
        $this->middleware(['permission:visitors_show'])->only('show');

        $this->visitorService = $visitorService;
    }
    public function index()
    {
        try {
            $visitingDetails = $this->visitorService->all();
            $i            = 1;
            $visitors = [];
            if (!blank($visitingDetails)) {
                foreach ($visitingDetails as $visitingDetail) {
                    $visitors[$i]['id'] = $visitingDetail->id;
                    $visitors[$i]['reg_no'] = $visitingDetail->reg_no;
                    $visitors[$i]['name'] = $visitingDetail->visitor->name;
                    $visitors[$i]['image'] = $visitingDetail->images;
                    $visitors[$i]['status'] = $visitingDetail->status;
                    $visitors[$i]['visitor_id'] = $visitingDetail->visitor->id;
                    $i++;
                }
                $visitors = VisitorResource::collection($visitors);
                return $this->successResponse(['status' => 200, 'data' => $visitors]);
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

    public function show($id)
    {
        $visitingDetails = $this->visitorService->find($id);
        if (!blank($visitingDetails)) {
            $visitor['name'] = $visitingDetails->visitor->name;
            $visitor['email'] = $visitingDetails->visitor->email;
            $visitor['reg_no'] = $visitingDetails->reg_no;
            $visitor['phone'] = $visitingDetails->visitor->phone;
            $visitor['image'] = $visitingDetails->user->images;
            $visitor['gender'] = $visitingDetails->visitor->gender;
            $visitor['company_name'] = $visitingDetails->company_name;
            $visitor['national_identification_no'] = $visitingDetails->visitor->national_identification_no;
            $visitor['address'] = $visitingDetails->visitor->address;
            $visitor['employee'] = $visitingDetails->employee->name;
            $visitor['purpose'] = $visitingDetails->purpose;
            $visitor['status'] = $visitingDetails->status;
            $visitor['created_at'] = date('y-m-d', strtotime($visitingDetails->created_at));

            $visitingDetails = new VisitorResource($visitor);
            return $this->successResponse(['status' => 200, 'data' => $visitingDetails]);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'The data not found',
            ], 401);
        }
    }

    public function store(Request $request)
    {
        $validator = new VisitorRequest();
        $validator = Validator::make($request->all(), $validator->rules());

        if (!$validator->fails()) {
            $visitingDetails = $this->visitorService->make($request);
            if ($visitingDetails) {
                return response()->json([
                    'status'  => 200,
                    'message' => 'Visitor Created Successfully.',
                ], 200);
            }
        } else {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = new VisitorRequest($request->visitor_id);
        $validator = Validator::make($request->all(), $validator->rules());
        $validator->after(function ($validator) {
            if (!$this->checkUniqueEmail(request('email'), request('visitor_id'))) {
                $validator->errors()->add('email', 'This Email Already Exists');
            }
            if (!$this->checkUniquePhone(request('phone'), request('visitor_id'))) {
                $validator->errors()->add('phone', 'This Phone Number Already Exists');
            }
        });

        if (!$validator->fails()) {
            $visitingDetails = $this->visitorService->update($request, $id);
            if ($visitingDetails) {
                return response()->json([
                    'status'  => 200,
                    'message' => 'Visitor Updated Successfully.',
                ], 200);
            }
        } else {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }
    }

    public function search($id)
    {

        $visitor = Visitor::Where('email', 'like', '%' . $id . '%')
            ->orWhere('phone', 'like', '%' . $id . '%')
            ->first();

        if (!$visitor) {

            $visitingDetails = VisitingDetails::where('reg_no', 'like', '%' . $id . '%')->first();
            if (!$visitingDetails) {

                return response()->json([
                    'status'  => 401,
                    'message' => 'No Visitor Found',
                ], 401);
            }
        } else {
            $visitingDetails = VisitingDetails::where('id', $visitor->id)->first();
        }
        if ($visitingDetails) {

            $visitor['id'] = $visitingDetails->id;
            $visitor['name'] = $visitingDetails->visitor->name;
            $visitor['email'] = $visitingDetails->visitor->email;
            $visitor['reg_no'] = $visitingDetails->reg_no;
            $visitor['phone'] = $visitingDetails->visitor->phone;
            $visitor['image'] = $visitingDetails->user->images;
            $visitor['gender'] = $visitingDetails->visitor->gender;
            $visitor['company_name'] = $visitingDetails->company_name;
            $visitor['national_identification_no'] = $visitingDetails->visitor->national_identification_no;
            $visitor['address'] = $visitingDetails->visitor->address;
            $visitor['employee'] = $visitingDetails->employee->name;
            $visitor['purpose'] = $visitingDetails->purpose;
            $visitor['status'] = $visitingDetails->status;
            $visitor['created_at'] = date('y-m-d', strtotime($visitingDetails->created_at));

            return $this->successResponse(['status' => 200, 'data' => $visitor]);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'No Visiting Details Found',
            ], 401);
        }
    }


    public function changeStatus($id, $status)
    {
        $visitor         = VisitingDetails::findOrFail($id);
        $visitor->status = $status;
        $visitor->checkin_at = date('y-m-d H:i');
        $visitor->save();
        try {
            $visitor->visitor->notify(new VisitorConfirmation($visitor));
            return $this->successResponse(['status' => 200, 'message' => 'Visitor Checked-In Successfully.']);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => 401,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function checkin(Request $request)
    {

        // dd($request->all());
        $validator = new VisitorRequest();
        $validator = Validator::make($request->all(), $validator->rules());

        if (!$validator->fails()) {
            $visitingDetails = $this->visitorService->make($request);

            if ($visitingDetails) {
                $visitor['name'] = $visitingDetails->visitor->name;
                $visitor['phone'] = $visitingDetails->visitor->phone;
                $visitor['reg_no'] = $visitingDetails->reg_no;
                $visitor['image'] = $visitingDetails->images;
                $visitor['employee'] = $visitingDetails->employee->name;
                $visitor['site_name'] = setting('site_name');
                $visitor['site_email'] = setting('site_email');
                $visitor['site_address'] = setting('site_address');


                $visitingDetails = new VisitorResource($visitor);
                return $this->successResponse(['status' => 200, 'data' => $visitingDetails]);
            }
        } else {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }
    }

    public function checkout($id)
    {
        $visitingDetail         = VisitingDetails::findOrFail($id);
        $visitingDetail->update(['checkout_at' => date('y-m-d H:i')]);
        return $this->successResponse(['status' => 200, 'message' => 'Visitor Checked-Out Successfully.']);
    }

    public function destroy($id)
    {
        $this->visitorService->delete($id);
        return $this->successResponse(['status' => 200, 'message' => 'Visitor Deleted Successfully.']);
    }

    public function find_visitor(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => [
                    'required',
                ],
            ],
            [
                'email.required' => 'The email or phone field is required. ',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $visitor = Visitor::where([['is_pre_register', false], ['email', request()->email]])->orWhere([['is_pre_register', false], ['phone', request()->email]])->first();
        if (!empty($visitor)) {

            $visitor['first_name'] = $visitor->first_name;
            $visitor['last_name'] = $visitor->last_name;
            $visitor['name'] = $visitor->first_name;
            $visitor['email'] = $visitor->email;
            $visitor['phone'] = $visitor->phone;
            $visitor['image'] = $visitor->images;
            $visitor['gender'] = $visitor->gender;
            $visitor['national_identification_no'] = $visitor->national_identification_no;
            $visitor['address'] = $visitor->address;
            $visitor['status'] = $visitor->status;
            $visitor['created_at'] = date('y-m-d', strtotime($visitor->created_at));
            $visitor = new SingleVisitorResource($visitor);
            return $this->successResponse(['status' => 200, 'data' => $visitor, 'visited_before' => 'Yes']);
        } else {
            return response()->json([
                'status'  => 422,
                'message' => 'Not Found',
                'visited_before' => 'No'
            ], 422);
        }
    }

    public function checkUniqueEmail($email, $id)
    {
        $user = Visitor::where('email', $email)->first();

        if ($user) {
            if ($user->id == $id) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }
    public function checkUniquePhone($phone, $id)
    {
        $user = Visitor::where('phone', $phone)->first();

        if ($user) {
            if ($user->id == $id) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }
}
