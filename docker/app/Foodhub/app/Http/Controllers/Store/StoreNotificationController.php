<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreNotification;

class StoreNotificationController extends Controller
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
    public function index()
    {
        $store = \Auth::user();
        $notifications = StoreNotification::where('store_id', $store->id)        ->get()
        ->sortByDesc('created_at');

        return view('store.notification.index', ['notifications'=>$notifications]);
    }

    public function update(Request $request) {
        $notification = StoreNotification::find($request->id);
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
