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
            //保存
        } catch (\Exception $e) {
            return back()->with('msg_danger', 'いいねに失敗しました');
        }
            //リダイレクト
            return back()->with('msg_success', 'いいねしました');
    }

    public function destroy(Request $request) {
        $user = \Auth::user();
        $favorite = Favorite::where('user_id', $user->id)->where('user_post_id', $request->id)->delete();
        return back()->with('msg_warning', 'いいねを削除しました');    }
}
