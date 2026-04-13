<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse;

class EmailVerificationResponse implements VerifyEmailResponse
{
    public function toResponse($request)
    {
        $user = $request->user();

        if (!$user->postal_code) {
            return redirect()->route('profile.edit');
        }

        return redirect()->route('mypage');
    }
}