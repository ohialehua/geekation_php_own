<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $deliveries = $user->deliveries;
        $cart_items = $user->cart_items;
        if ($cart_items) {
            return view('user.order.new', ['deliveries'=>$deliveries, 'cart_items'=>$cart_items]);
        } else {
            return back()->with('msg_warning', 'カートに商品を入れてください');
        }
    }

    public function confirm(Request $request){
        $user = \Auth::user();
        $cart_items = $user->cart_items;
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
        $cart_items = $user->cart_items;

        DB::beginTransaction();

        // try {
                $order = new Order($request->all());
                $order->user_id = $request->user()->id;
                $order->save();
                foreach ($cart_items as $cart_item) {
                    $store = $cart_item->item->store;
                    //  カート内の商品の加盟店で、この注文でまだ$store_orderができていないなら
                      if (StoreOrder::whereStoreId($store->id)->whereOrderId($order->id)->count() == 0) {
                    //  加盟店ごとの注文書を作成
                        $store_order = StoreOrder::create([
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                            'store_id' => $store->id,
                        ]);
                        $store_order_id = $store_order->id;
                      } else {
                    //  既にある加盟店ごとの注文書の一番目のIDを取得
                        $store_order_id = StoreOrder::whereStoreId($store->id)->whereOrderId($order->id)->first()->id;
                      }

                    $order_item = OrderItem::create([
                        'order_id' => $order->id,
                        'store_order_id' => $store_order_id,
                        'item_id' => $cart_item->item->id,
                        'quantity' => $cart_item->quantity,
                        'price_after_tax' => $cart_item->item->price_before_tax * $tax,
                      ]);
                //  商品の累計数加算
                    $item = Item::find($cart_item->item_id);
                    $item->sales_figures += $order_item->quantity;
                    $item->save();
                }
            //  カート内商品の削除
                CartItem::query($request->user_id)->delete();

            if ($order->pay_method == 0) {
            //  シークレットキーを設定
                \Payjp\Payjp::setApiKey(config('payjp.secret_key'));

            //  支払い処理
            // 新規支払い情報作成
                \Payjp\Charge::create([
                  "card" => $request->get('payjp-token'),
                  "amount" => $order->total_price,
                  "currency" => 'jpy',
                ]);
            }

            // 不要な「_token」の削除
            unset($order['_token']);
            //保存
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return back()->with('msg_danger', '注文の確定に失敗しました。入力情報などに誤りはありませんか？');
        // }
        DB::commit();
        return redirect('user/order/complete')->with('msg_success', '注文を完了しました');
    }

    public function complete(){
        $user = \Auth::user();
        $order = Order::whereUserId($user->id)->latest()->first();
        $order_items = $order->order_items;
        return view('user.order.complete', ['order'=>$order, 'order_items'=>$order_items]);
    }

    public function index(){
    }

    public function show($id) {
        $order = Order::find($id);
        return view('user.order.show', ['order'=>$order]);
    }
}
