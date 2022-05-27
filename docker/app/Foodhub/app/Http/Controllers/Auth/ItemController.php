<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Store;
use App\Models\CartItem;

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
        $user = \Auth::user();
        $items = Item::all();
        $markers = $user->markers;
        return view('user.item.index', ['items'=>$items, 'markers'=>$markers]);
    }

    public function show($id) {
        $item = Item::find($id);
        $user = \Auth::user();
        $tax = 1.1;
        // $cart_items = CartItem::whereUserId($user->id);
        // $Item = new Item;
        // $price_with_tax = [];
        // foreach ($cart_items as $ci) {
        //     $price_with_tax = $Item->tax($ci->item->price_before_tax);
        //     return $price_with_tax;
        // }
        return view('user.item.show', ['item'=>$item, 'user'=>$user, 'tax'=>$tax,
        //  'price_with_tax'=>$price_with_tax
         ]);
    }
}
