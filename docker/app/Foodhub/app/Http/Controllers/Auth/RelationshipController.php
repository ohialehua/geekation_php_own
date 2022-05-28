<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relationship;
use App\Models\User;

class RelationshipController extends Controller
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
    public function follow(Request $request)
    {
        $user = \Auth::user();
        $following = User::find($request->user_id);
        try {
                $relationship = new Relationship();
                $relationship->followed_id = $user->id;
                $relationship->follower_id = $following->id;
                $relationship->save();
            // 不要な「_token」の削除
            unset($relationship['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg_danger', 'フォローに失敗しました');
        }
            //リダイレクト
            return back()->with('msg_primary', "{$following->name}さんをフォローしました");
    }

    public function unfollow(Request $request) {
        $user = \Auth::user();
        $following = User::find($request->user_id);
        $relationship = Relationship::where('followed_id', $user->id)->where('follower_id', $following->id)->delete();
        return back()->with('msg_secondary', "{$following->name}さんをフォローから外しました");
    }
}
