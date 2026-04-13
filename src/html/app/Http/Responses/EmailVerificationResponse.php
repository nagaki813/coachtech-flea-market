<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse;

class EmailVerificationResponse implements VerifyEmailResponse
{
    public function toResponse($request)
    {
        return redirect()->route('profile.edit');
    }
}