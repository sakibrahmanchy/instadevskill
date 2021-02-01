<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\FollowRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepo;
    private $followRepo;
    public function __construct(UserRepositoryInterface $userRepository,
                                FollowRepositoryInterface $followRepository)
    {
        $this->userRepo = $userRepository;
        $this->followRepo = $followRepository;
    }

    public function follow(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        $user = $this->userRepo->find($request->user_id);

        if ($user->account_type === 1) {
            $followed = $this->followRepo->create([
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

    public function unfollow(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        $currentUserId = Auth::id();

        $followerFollowee = $this->followRepo
            ->where("user_id", $request->user_id)
            ->where('follower_id', $currentUserId);

        if ($followerFollowee->first()) {
            try {
                $followerFollowee->delete();
                return response()->json([
                    'message' => "You no longer follow user $request->user_id"
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => "Something wrong happened. Try again later!"
                ], 200);
            }

        }

        return response()->json([
            'message' => "You cannot unfollow $request->user_id, because you don't follow the user yet!"
        ]);
    }

    public function followers(Request $request)
    {
        $followers = $this->followRepo->with(['user' => function($query) {
            $query->select('id', 'username', 'name', 'email');
        }])
        ->where('user_id', $request->user()->id)
        ->get()
        ->pluck('user');

        return response()->json(['followers' => $followers]);
    }
}
