<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Item;

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
        $items = Store::find($store->id)->items;
                // ->orderBy('created_at', 'desc');
        return view('store.home', ['store'=>$store, 'items'=>$items]);
    }
}
