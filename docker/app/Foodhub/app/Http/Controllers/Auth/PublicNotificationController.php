<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublicNotification;
// use App\Models\StoreOrder;
// use App\Models\User;
// use App\Models\Store;
// use App\Models\PostComment;
// use App\Models\UserPost;
// use App\Models\StorePost;

class PublicNotificationController extends Controller
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
    public function index()
    {
        $user = \Auth::user();
        $notifications = PublicNotification::where('receiver_id', $user->id)
        ->orWhere('user_id', $user->id)
        ->get()
        ->sortByDesc('created_at');

        return view('user.notification.index', ['notifications'=>$notifications]);
    }

    public function update(Request $request) {
        $notification = PublicNotification::find($request->id);
    try {
        $notification->checked = $request->checked;
        //保存
        $notification->save();
    } catch (\Exception $e) {
        return back()->with('msg_danger', '通知の確認に失敗しました');
    }
        //リダイレクト
        if ($notification->checked == 1) {
            return back()->with('msg_success', '通知を確認しました');
        } else {
            return back()->with('msg_secondary', '通知を未読にしました');
        }
    }

}
