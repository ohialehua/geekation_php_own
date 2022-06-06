<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserPost;
use App\Models\Relationship;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $user = \Auth::user();
        $posts = $user->user_posts
               ->sortByDesc('created_at');;
        $following_count = Relationship::where('followed_id', $user->id)->count();
        $follower_count = Relationship::where('follower_id', $user->id)->count();
        return view('home',
                   [
                    'user'=>$user,
                    'posts'=>$posts,
                    'following_count'=>$following_count,
                    'follower_count'=>$follower_count,
                   ]);
    }
}
