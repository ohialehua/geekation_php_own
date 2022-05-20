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
        $stores = Store::all();
        return view('user.store.index', ['stores'=>$stores]);
    }

    public function show($id) {
        $store = Store::find($id);
        $items = Store::find($store->id)->items
                ->sortByDesc('created_at');
        return view('user.store.show', ['store'=>$store, 'items'=>$items]);
    }
}
