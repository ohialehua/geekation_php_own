<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\Item;
use App\Models\PublicNotification;

class StoreOrderController extends Controller
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
    public function index() {
        $store = \Auth::user();
        $store_orders = $store->store_orders->sortByDesc('created_at');
        return view('store.store_order.index', ['store_orders'=>$store_orders]);
    }

    public function show($id) {
        $postage = 200;
        $store = \Auth::user();
        $store_order = StoreOrder::find($id);
        $order = $store_order->order;
        $order_items = $store_order->order_items;
        return view('store.store_order.show',
        [
            'store_order'=>$store_order,
            'order'=>$order,
            'order_items'=>$order_items,
            'postage'=>$postage,
        ]);
    }

    public function update(Request $request) {
        $store_order = StoreOrder::find($request->id);
        $order_items = $store_order->order_items;
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $store_order->fill($params)->save();
        // 注文ステータスを「入金確認」に変更したら
        if ($store_order->order_status == 1) {
          foreach ($order_items as $order_item) {
            //   注文商品の製作ステータスを全て「製作中」に
              $order_item->update(['product_status'=> 1 ]);
          }
            return back()->with('msg_warning', '入金を確認しました');
        // 注文ステータスが「発送完了」なら
        } elseif ($store_order->order_status == 4) {
            //通知を作成
            $notification = new PublicNotification();
            $notification->user_id = $store_order->user_id;
            $notification->store_id = $store_order->store_id;
            $notification->store_order_id = $store_order->id;
            $notification->action = 'order';

            $notification->save();
            return back()->with('msg_success', '発送が完了しました');
        }
    } catch (\Exception $e) {
        return back()->with('msg_danger', '注文ステータスの変更に失敗しました');
    }
        //リダイレクト
        return back()->with('msg_secondary', '注文ステータスを変更しました');
    }
}
