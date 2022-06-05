<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Models\User;
use App\Models\Store;
use App\Models\UserPost;
use App\Models\StorePost;
use App\Models\PublicNotification;
use App\Models\StoreNotification;

class PostCommentController extends Controller
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
    public function create(Request $request)
    {
        $user = \Auth::user();
        try {
                $comment = new PostComment($request->all());
                $comment->save();
            // 不要な「_token」の削除
            unset($comment['_token']);
               if ( isset($comment->user_post_id) ) {
                  $notification = new PublicNotification();
                  $notification->sender_id = $user->id;
                  $notification->receiver_id = $comment->user_post->user_id;
                  $notification->post_comment_id = $comment->id;
                  $notification->action = 'comment';
               } elseif ( isset($comment->store_post_id) ) {
                  $notification = new StoreNotification();
                  $notification->user_id = $user->id;
                  $notification->store_id = $comment->store_post->store_id;
                  $notification->post_comment_id = $comment->id;
                  $notification->action = 'comment';
               }
               $notification->save();
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
