<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Store;

class ItemController extends Controller
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
        $items = Item::all();
        return view('user.item.index', ['items'=>$items]);
    }

    public function show($id) {
        $item = Item::find($id);
        $user = \Auth::user();
        $Item = new Item;
        $price_with_tax = $Item->price_with_tax();
        return view('user.item.show', ['item'=>$item, 'user'=>$user, 'price_with_tax'=>$price_with_tax ]);
    }
}
