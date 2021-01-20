<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function follow(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::where('id', $request->user_id)->first();

        if ($user->account_type === 1) {
            $followed = Follow::create([
                'user_id' => $request->user_id,
                'follower_id' => Auth::id(),
            ]);

            return response()->json([
                'follow' => $followed
            ]);
        } else {
            return response()->json([
                'message' => 'This is a private account. This user needs to approve before following',
            ]);
        }
    }


    public function followers(Request $request)
    {
        $followers = DB::table('users')
            ->select('*')
            ->join('follows', 'users.id', '=', 'follows.user_id')
            ->where('users.id', '=', $request->user()->id)
            ->get();

        // Fetch Name, emails and other details of all follwers

        dd($followers);
        // Inefficient way
//        return $request->user()->followers->map(function($follower) {
//            return User::where('id', $follower->follower_id)->get();
//        });
    }

}
