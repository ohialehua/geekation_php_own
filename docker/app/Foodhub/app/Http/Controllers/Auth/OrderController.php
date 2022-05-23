<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Delivery;
use App\Models\Store;

class OrderController extends Controller
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
    public function new(){
        $user = \Auth::user();
        $deliveries = Delivery::whereUserId($user->id)->get();
        return view('user.order.new', ['deliveries'=>$deliveries]);
    }

    public function confirm(Request $request){
        $user = \Auth::user();
        $cart_items = CartItem::whereUserId($user->id)->get();
        $tax = 1.1;
        $pay_method = $request->pay_method;
        if ($request->delivery_method == 0) {
            $delivery = Delivery::find($request->delivery_id);
        } elseif ($request->delivery_method == 1) {
            try {
                $delivery = new Delivery();
                $delivery->user_id = $request->user()->id;
                $delivery->name = $request->name;
                $delivery->post_address = $request->post_address;
                $delivery->address = $request->address;

                $delivery->save();
            // 不要な「_token」の削除
            unset($delivery['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg_danger', '配送先登録に失敗しました');
        }
        };
        // 「itemsテーブルにある "user_idが$user->idであるcart_itemsテーブル" 」をもつStoreの数
        $store_amount = Store::whereHas('items.cart_items', function($q) use($user) {
                          $q->whereUserId($user->id);
                        })->count();
        $postage = $store_amount * 200;
        return view('user.order.confirm', [
            'cart_items'=>$cart_items,
            'tax'=>$tax,
            'postage'=>$postage,
            'pay_method'=>$pay_method,
            'delivery'=>$delivery,
         'store_amount'=>$store_amount
        ]);
    }

    public function create(Request $request){
        $tax = 1.1;
        $user = \Auth::user();
        $cart_items = CartItem::whereUserId($user->id)->get();
        // try {
                $order = new Order($request->all());
                $order->user_id = $request->user()->id;
                $order->save();
                foreach ($cart_items as $ci) {
                    $stores = Store::whereHas('items.cart_items', function($q) use($user) {
                        $q->whereUserId($user->id);
                    })->distinct()->get();
                    foreach ($stores as $store) {
                      if (StoreOrder::whereStoreId($store->id)->whereOrderId($order->id)->count() == 0) {
                        $store_order = StoreOrder::create([
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                            'store_id' => $store->id,
                        ]);
                        $store_order_id = $store_order->id;
                      } else {
                        $store_order_id = StoreOrder::whereStoreId($store->id)->whereOrderId($order->id)->first()->id;
                      }
                    }

                    $order_item = OrderItem::create([
                        'order_id' => $order->id,
                        'store_order_id' => $store_order_id,
                        'item_id' => $ci->item->id,
                        'quantity' => $ci->quantity,
                        'price_after_tax' => $ci->item->price_before_tax * $tax,
                      ]);
                }
            // 不要な「_token」の削除
            unset($order['_token']);
            //保存
        // } catch (\Exception $e) {
        //     return back()->with('msg_danger', '注文の確定に失敗しました。入力情報などに誤りはありませんか？');
        // }
        return redirect('user/order/complete')->with('msg_success', '注文を完了しました');
    }

    public function complete(){
        return view('user.order.complete');
    }

    public function index(){
    }

    public function show($id) {
        $order = Order::find($id);
        return view('user.order.show', ['order'=>$order]);
    }
}
