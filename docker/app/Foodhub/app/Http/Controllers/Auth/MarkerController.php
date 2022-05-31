<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreNotification;
use App\Models\Marker;
use App\Models\User;
use App\Models\Store;

class MarkerController extends Controller
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
        $store = Store::find($request->store_id);
        try {
                $marker = new Marker($request->all());
                $marker->store_id = $store->id;
                $marker->user_id = $user->id;
                $marker->save();
            // 不要な「_token」の削除
            unset($marker['_token']);
                $notification = new StoreNotification();
                $notification->user_id = $user->id;
                $notification->store_id = $store->id;
                $notification->action = 'mark';
                $notification->save();
        } catch (\Exception $e) {
            return back()->with('msg_danger', 'お気に入りに失敗しました');
        }
            //リダイレクト
            return back()->with('msg_warning', "{$store->name}をお気に入りに追加しました");
    }

    public function destroy(Request $request) {
        $user = \Auth::user();
        $store = Store::find($request->store_id);
        $marker = Marker::where('user_id', $user->id)->where('store_id', $request->store_id)->delete();
        return back()->with('msg_secondary', "{$store->name}をお気に入りからはずしました");
    }
}
