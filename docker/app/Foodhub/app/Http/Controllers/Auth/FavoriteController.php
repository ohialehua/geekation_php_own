<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\UserPost;
use App\Models\StorePost;

class FavoriteController extends Controller
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
                $favorite = new Favorite($request->all());
                $favorite->user_id = $user->id;
                $favorite->save();
            // 不要な「_token」の削除
            unset($favorite['_token']);
            if ( isset($favorite->user_post_id) ) {
                $notification = new PublicNotification();
                $notification->sender_id = $user->id;
                $notification->receiver_id = $favorite->user_post->user_id;
                $notification->action = 'like';
             } elseif ( isset($favorite->store_post_id) ) {
                $notification = new StoreNotification();
                $notification->user_id = $user->id;
                $notification->store_id = $favorite->store_post->store_id;
                $notification->action = 'like';
             }
             $notification->save();
        } catch (\Exception $e) {
            return back()->with('msg_danger', 'いいねに失敗しました');
        }
            //リダイレクト
            return back()->with('msg_info', 'いいねしました');
    }

    public function destroy(Request $request) {
        $user = \Auth::user();
        $favorite = Favorite::where('user_id', $user->id)->where('user_post_id', $request->user_post_id)->delete();
        return back()->with('msg_danger', 'いいねを削除しました');    }
}
