<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{

    /**
     * FollowersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('follow',$user);
        if(!Auth::user()->isFollowing($user->id)){
            Auth::user()->follow($user->id);
        }
        return back();
    }

    public function destroy(User $user)
    {
        $this->authorize('follow',$user);
        if(Auth::user()->isFollowing($user->id)){
            Auth::user()->unfollow($user->id);
        }
        return back();
    }
}
