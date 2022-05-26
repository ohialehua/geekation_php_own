<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StorePost;

class StorePostController extends Controller
{
    public function show($id) {
        $post = StorePost::find($id);
        return view('user.store_post.show', ['post'=>$post]);
    }
}
