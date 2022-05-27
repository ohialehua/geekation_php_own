<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Models\User;
use App\Models\Store;
use App\Models\UserPost;
use App\Models\StorePost;

class PostCommentController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        try {
                $comment = new PostComment($request->all());
                $comment->save();
            // 不要な「_token」の削除
            unset($comment['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg_danger', 'コメントに失敗しました');
        }
            //リダイレクト
            return back()->with('msg_success', 'コメントしました');
    }

    public function destroy($id) {
        $post_comment = PostComment::find($id)->delete();
        return back()->with('msg_warning', 'コメントを削除しました');    }
}
