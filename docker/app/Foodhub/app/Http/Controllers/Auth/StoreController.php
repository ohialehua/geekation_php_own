<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Item;


class StoreController extends Controller
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

    public function index() {
        $user = \Auth::user();
        $stores = Store::all();
        $markers = $user->markers;
        return view('user.store.index', ['stores'=>$stores, 'markers'=>$markers]);
    }

    public function show($id) {
        $postage = 200;
        $user = \Auth::user();
        $store = Store::find($id);
        $items = $store->items
                ->sortByDesc('created_at');
        $posts = $store->store_posts
                ->sortByDesc('created_at');
        $store_orders = $store->store_orders->where('user_id', $user->id)
                ->sortByDesc('created_at');
        return view('user.store.show',
                   [
                    'postage'=>$postage,
                    'store'=>$store,
                    'items'=>$items,
                    'posts'=>$posts,
                    'store_orders'=>$store_orders
                   ]);
    }
}
