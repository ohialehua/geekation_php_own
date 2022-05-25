<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\Item;

class OrderItemController extends Controller
{
    public function update(Request $request) {
        $order_item = OrderItem::find($request->id);
        $store_order = $order_item->store_order;
        $order_items = $store_order->order_items;
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $order_item->fill($params)->save();
        // 製作ステータスが「製作中」が1つでもあるなら
        if ($order_item->product_status == 2) {
            // この注文の注文ステータスを「製作中」に
            $store_order->update(['order_status'=> 2 ]);
            return back()->with('msg_warning', 'まだ製作中の商品があります');
        // 注文商品の数と"製作ステータスが「製作完了」"である注文商品の数より1小さいなら
        // →これから「製作完了」に更新する製作ステータスが最後の1つなら
        } elseif ($order_items->count()-1 === $order_items->where('product_status', 3)->count()) {
            // この注文の注文ステータスを「発送準備中」に
            $store_order->update(['order_status'=> 3 ]);
            return back()->with('msg_success', 'すべての商品の製作が完了しました');
        }
    } catch (\Exception $e) {
        return back()->with('msg_danger', '製作ステータスの変更に失敗しました');
    }
        //リダイレクト
        return back()->with('msg_secondary', '製作ステータスを変更しました');
    }
}
