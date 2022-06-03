<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\VisitingDetails;
use App\Models\Visitor;
use App\Notifications\SendVisitorToEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use NotificationChannels\Twilio\TwilioChannel;

class CheckoutController extends Controller
{

    function __construct()
    {
    }

    public function index(Request $request)
    {

        return view('frontend.checkout.index', ['details' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getVisitor(Request $request)
    {
        
        $request->validate(
            ['visitorID' => 'required|numeric',],
            ['visitorID.required' => 'Visitor ID required', 'visitorID.numeric' => 'ID must be numeric']
        );

        $visitingDetails = VisitingDetails::where('reg_no', $request->visitorID)->first();
        $details = false;

        return view('frontend.checkout.index', compact('visitingDetails', 'details'));
    }

    public function update(VisitingDetails $visitingDetails)
    {
        //dd($visitingDetails->id);
        $visitingDetails->checkout_at = date('y-m-d H:i');
        $visitingDetails->save();
        return redirect()->route('/')->with('success', 'Successfully Check-Out');
    }
}
