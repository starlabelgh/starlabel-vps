<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\VisitorStatus;
use App\Models\Visitor;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitingDetails;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Services\JwtTokenService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EmployeConfirmation;
use App\Notifications\SendVisitorToEmployee;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use App\Notifications\SendInvitationToVisitors;

class CheckInController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
        session()->forget('visitor');
        session()->forget('is_returned');
        // return view('frontend.check-in.dashboard');
        return view('frontend.check-in.home-page');
    }

    /**
     * Show the step 1 Form for creating a new product.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createStepOne(Request $request)
    {
        $employees = Employee::all();
        $visitor = $request->session()->get('visitor');

        return view('frontend.check-in.step-one', compact('employees', 'visitor'));
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateStepOne(Request $request)
    {

        if ($request->session()->get('is_returned') == false || empty($request->session()->get('is_returned'))) {
            $validatedData = $request->validate([
                'first_name'                 => 'required',
                'last_name'                  => 'required',
                'email'                      => 'required|unique:visitors,email',
                'phone'                      => 'required|unique:visitors,phone',
                'purpose'                    => 'required',
                'employee_id'                => 'required|numeric',
                'gender'                     => 'required|numeric',
                'company_name'               => '',
                'company_employee_id'        => '',
                'national_identification_no' => '',
                'is_group_enabled'           => '',
                'address'                    => '',
            ]);
        } else {
            $visitor = Visitor::where('email', $request->get('email'))->first();
            if ($visitor) {
                $email = ['required', 'email', 'string', Rule::unique("visitors", "email")->ignore($visitor)];
                $phone = ['required', 'string', Rule::unique("visitors", "phone")->ignore($visitor)];
            } else {
                $email = ['required', 'email', 'string', 'unique:visitors,email'];
                $phone = ['required',  'string', 'unique:visitors,phone'];
            }
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => $email,
                'phone' => $phone,
                'purpose' => 'required',
                'employee_id' => 'required|numeric',
                'gender' => 'required|numeric',
                'company_name' => '',
                'company_employee_id' => '',
                'national_identification_no' => '',
                'is_group_enabled' => '',
                'address' => '',
            ]);
        }

        $request->session()->put('visitor', $validatedData);

        return redirect()->route('check-in.step-two');
    }

    /**
     * Show the step 2 Form for creating a new product.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createStepTwo(Request $request)
    {
        $visitingDetails = $request->session()->get('visitor');
        $employee = Employee::find($visitingDetails['employee_id']);

        return view('frontend.check-in.step-two', compact('employee', 'visitingDetails'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $getVisitor = $request->session()->get('visitor');
        if ($getVisitor) {
            $imageName = null;
            if ($request->has('photo')) {
                if (setting('photo_capture_enable')) {
                    $request->validate([
                        'photo' => 'required',
                    ]);
                }

                $encoded_data = $request['photo'];
                $image = str_replace('data:image/png;base64,', '', $encoded_data);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10) . '.' . 'png';
                file_put_contents($imageName, base64_decode($image));
                $url = public_path($imageName);
            }
        } else {
            redirect()->route('check-in.step-one')->with('error', 'visitor information not found, fill again!');
        }

        $visitorID = DB::table('visiting_details')->max('id');
        $visitorReg = VisitingDetails::find($visitorID);
        $date = date('y-m-d');
        $data = substr($date, 0, 2);
        $data1 = substr($date, 3, 2);
        $data2 = substr($date, 6, 8);
        $today = $data2 . $data1 . $data;

        if (!blank($visitorReg)) {
            $lastentrydmy = substr($visitorReg->reg_no, 0, 6);
            if ($lastentrydmy == $today) {
                $value = substr($visitorReg->reg_no, 6);
                $value += 1;
                $reg_no = $data2 . $data1 . $data . $value;
            } else {
                $reg_no = $data2 . $data1 . $data . '1';
            }
        } else {
            $reg_no = $data2 . $data1 . $data . '1';
        }

        if ($request->session()->get('is_returned') == false || empty($request->session()->get('is_returned'))) {

            $input['first_name'] = $getVisitor['first_name'];
            $input['last_name'] = $getVisitor['last_name'];
            $input['email'] = $getVisitor['email'];
            $input['phone'] = $getVisitor['phone'];
            $input['gender'] = $getVisitor['gender'];
            $input['address'] = $getVisitor['address'];
            $input['national_identification_no'] = $getVisitor['national_identification_no'];
            $input['is_pre_register'] = false;
            $input['status'] = Status::ACTIVE;
            $input['creator_id'] = 1;
            $input['creator_type'] = 'App\User';
            $input['editor_type'] = 'App\User';
            $input['editor_id'] = 1;
            $visitor = Visitor::create($input);
        } else {
            $visitor = Visitor::where('email', $getVisitor['email'])->first();
            $visitor->first_name = $getVisitor['first_name'];
            $visitor->last_name = $getVisitor['last_name'];
            $visitor->email = $getVisitor['email'];
            $visitor->phone = $getVisitor['phone'];
            $visitor->gender = $getVisitor['gender'];
            $visitor->address = $getVisitor['address'];
            $visitor->national_identification_no = $getVisitor['national_identification_no'];
            $visitor->is_pre_register = false;
            $visitor->save();
        }

        if ($visitor) {
            $visiting['reg_no'] = $reg_no;
            $visiting['purpose'] = $getVisitor['purpose'];
            $visiting['company_name'] = $getVisitor['company_name'];
            $visiting['employee_id'] = $getVisitor['employee_id'];
            $visiting['visitor_id'] = $visitor->id;
            $visiting['status'] = VisitorStatus::PENDDING;
            $visiting['user_id'] = $getVisitor['employee_id'];
            $visiting['creator_id'] = 1;
            $visiting['creator_type'] = 'App\User';
            $visiting['editor_type'] = 'App\User';
            $visiting['editor_id'] = 1;
            $visitingDetails = VisitingDetails::create($visiting);
            if ($imageName) {
                $visitingDetails->addMedia($imageName)->toMediaCollection('visitor');
                File::delete($imageName);
            }

            try {

                $token =  app(JwtTokenService::class)->jwtToken($visitingDetails);
                $visitingDetails->employee->user->notify(new EmployeConfirmation($visitingDetails, $token));
            } catch (\Exception $e) {
                // Using a generic exception

            }
        }
        return redirect()->route('check-in.show', $visitingDetails->id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $visitingDetails = VisitingDetails::find($id);
        if ($visitingDetails) {
            return view('frontend.check-in.show', compact('visitingDetails'));
        } else {
            session()->forget('visitor');
            session()->forget('is_returned');
            return redirect('/check-in');
        }
    }

    public function visitor_return()
    {
        return view('frontend.check-in.return');
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
        $validator->after(function ($validator) {
            if (!$this->checkPreRegister(false)) {
                $validator->errors()->add('email', 'Visitor not found!');
            }
        });


        if ($validator->fails()) {
            return redirect()->route('check-in.return')
                ->withErrors($validator)
                ->withInput();
        }

        $visitor = Visitor::where([['is_pre_register', false], ['email', request()->email]])->orWhere([['is_pre_register', false], ['phone', request()->email]])->first();

        if (!empty($visitor)) {
            $request->session()->put('visitor', $visitor);
            $request->session()->put('is_returned', true);
            return redirect()->route('check-in.step-one');
        }
        return redirect()->route('check-in.return');
    }

    public function checkPreRegister($boolean)
    {

        $visitor = Visitor::where([['is_pre_register', $boolean], ['email', request()->email]])->orWhere([['is_pre_register', $boolean], ['phone', request()->email]])->first();
        if ($visitor) {
            return true;
        } else {
            return false;
        }
    }
    public function find_pre_visitor(Request $request)
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
        $validator->after(function ($validator) {
            if (!$this->checkPreRegister(true)) {
                $validator->errors()->add('email', 'Pre-Register not found!');
            }
        });



        if ($validator->fails()) {
            return redirect()->route('check-in.pre.registered')
                ->withErrors($validator)
                ->withInput();
        }
        $visitor = Visitor::where([['is_pre_register', true], ['email', request()->email]])->orWhere([['is_pre_register', true], ['phone', request()->email]])->first();

        if (!empty($visitor)) {
            $request->session()->put('visitor', $visitor);
            $request->session()->put('is_returned', true);

            return redirect()->route('check-in.step-one');
        }

        return redirect()->route('check-in.pre.registered');
    }

    public function pre_registered()
    {
        return view('frontend.check-in.pre_registered');
    }

}
