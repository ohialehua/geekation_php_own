<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StorePost;

class StorePostController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id) {
        $user = \Auth::user();
        $post = StorePost::find($id);
        $post_comments = $post->post_comments;
        return view('user.store_post.show', ['user'=>$user, 'post'=>$post, 'post_comments'=>$post_comments]);
    }
}
