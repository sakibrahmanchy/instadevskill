<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $userRepo;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'date_of_birth' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'phone' => 'required|unique:users,phone'
        ]);

        $user = $this->userRepo->create(array_merge(
            $request->except('password'),
            [
                'password' => bcrypt($request->password),
            ]
        ));

        event(new Registered($user));

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::user();

            $token = $user->createToken($user->email.'-'.now());

            return response()->json([
                'token' => $token->accessToken,
            ]);
        } else {
            return response()->json([
                'message' => "Invalid email or password",
            ]);
        }
    }
}
