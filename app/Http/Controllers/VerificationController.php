<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    private $userRepo;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function verify($id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Invalid/expired url provided'
            ], 401);
        }

        $user = $this->userRepo->find($id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => "Email successfully verified",
        ], 200);
    }

    public function resend()
    {
        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return response()->json([
                'message' => "Verification mail resent to your email."
            ]);
        }

        return response()->json([
            'message' => "Email already verified."
        ], 400);
    }
}
