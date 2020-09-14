<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    // 关注
    public function store(User $user)
    {
        $this->authorize('follow', $user);
        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', compact('user'));
    }

    // 取消关注
    public function destroy(User $user)
    {
        $this->authorize('follow', $user);
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unFollow($user->id);
        }
        return redirect()->route('users.show', compact('user'));
    }
}
