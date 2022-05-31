<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Item;
use App\Models\StorePost;
use App\Models\AdminNotification;

class HomeController extends Controller
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
    public function show(Store $store)
    {
        $store = \Auth::user();
        if ($store->is_deleted == 0) {
            AdminNotification::create([
                'admin_id' => 2,
                'store_id' => $store->id,
            ]);
            Auth::logout();
            return redirect('/store/login')->with('msg_success', '登録を確認しました。アカウント情報を精査いたします。ご登録いただいたEmailに追って連絡いたしますので今しばらくおまちください。');
        }
        $items = $store->items
                ->sortByDesc('created_at');
        $posts = $store->store_posts
                ->sortByDesc('created_at');
        return view('store.home', ['store'=>$store, 'items'=>$items, 'posts'=>$posts]);
    }
}
