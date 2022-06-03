<?php

namespace App\Http\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use App\Models\VisitingDetails;
use App\Notifications\VisitorConfirmation;

class JwtTokenService
{
    public function jwtToken($visitor)
    {
        $secretKey  = Env('JWT_SECRET');
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+30 minutes')->getTimestamp();

        $data = [
            'iat'              => $issuedAt->getTimestamp(),   // Issued at: time when the token was generated
            'nbf'              => $issuedAt->getTimestamp(),   // Not before
            'exp'              => $expire,                     // Expire
            'userName'         => $visitor->employee->name,
            'userID'           => $visitor->employee->id,
            'visitorID'        => $visitor->id,
            'employee_user_id' => $visitor->employee->user->id,
        ];

        $token = JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );
        return $token;
    }

    public function jwtTokenDecode($token)
    {
        $secretKey  = Env('JWT_SECRET');
        $tokenData = JWT::decode($token, new Key($secretKey, 'HS512'));
        return $tokenData;
    }
    public function changeStatus($visitorID,$status)
    {
        $visitor = VisitingDetails::findOrFail($visitorID);
        $visitor->status    = $status;
        $visitor->checkin_at = date('y-m-d H:i');
        $visitor->save();
        $visitor->visitor->notify(new VisitorConfirmation($visitor));
    }
}
