<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\Item;

class StoreOrderController extends Controller
{
    public function index() {
        $store = \Auth::user();
        $store_orders = $store->store_orders->sortByDesc('created_at');;
        return view('store.store_order.index', ['store_orders'=>$store_orders]);
    }

    public function show($id) {
        $postage = 200;
        $store_order = StoreOrder::find($id);
        $order = $store_order->order;
        $order_items = $order->order_items;
        return view('store.store_order.show',
        [
            'store_order'=>$store_order,
            'order'=>$order,
            'order_items'=>$order_items,
            'postage'=>$postage,
        ]);
    }
}
