<?php

namespace App\Http\Controllers;

use jwt;
use App\Models\VisitingDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\JwtTokenService;
use Illuminate\Support\Facades\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Notifications\VisitorConfirmation;
use App\User;

class FrontendController extends Controller
{
    public $data = [];
    protected $jwtTokenService;

    public function __construct(JwtTokenService $jwtTokenService)
    {
        $this->data['site-title'] = 'Frontend';
        $this->jwtTokenService = $jwtTokenService;
    }
    public function changeStatus($status, $token)
    {
        try {
            $data =  $this->jwtTokenService->jwtTokenDecode($token);
            if (auth()->user()) {
                $this->jwtTokenService->changeStatus($data->visitorID, $status);
                return redirect()->route('admin.dashboard.index')->withSuccess('The Status Change successfully!');
            } else {
                $result = User::findorFail($data->employee_user_id);
                if ($result) {
                    Auth::login($result);
                    $this->jwtTokenService->changeStatus($data->visitorID, $status);
                    return redirect()->route('admin.dashboard.index')->withSuccess('The Status Change successfully!');
                } else {
                    return redirect()->route('/')->withError('These credentials do not match our records');
                }
            }
        } catch (\Exception $e) {
            //
        }
    }
}
