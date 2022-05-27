<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Item;
use App\Models\StorePost;

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
        $items = $store->items
                ->sortByDesc('created_at');
        $posts = $store->store_posts
                ->sortByDesc('created_at');
        return view('store.home', ['store'=>$store, 'items'=>$items, 'posts'=>$posts]);
    }
}
