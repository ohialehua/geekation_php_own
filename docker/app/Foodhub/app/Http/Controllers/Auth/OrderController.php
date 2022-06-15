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
use App\Models\StoreNotification;

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
        if ($cart_items->isEmpty()) {
            return back()->with('msg_warning', 'カートに商品を入れてください');
        } else {
            return view('user.order.new', ['deliveries'=>$deliveries, 'cart_items'=>$cart_items]);
        }
    }

    public function confirm(Request $request){
        $user = \Auth::user();
        $cart_items = $user->cart_items;
        // 税金
        $tax = 1.1;
        $pay_method = $request->pay_method;
        // 既存の配送先か新しい配送先かで場合分け
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
        // 注文商品の加盟店の数×200
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

        try {
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
                        //通知を作成
                          $notification = new StoreNotification();
                          $notification->user_id = $user->id;
                          $notification->store_id = $store->id;
                          $notification->store_order_id = $store_order->id;
                          $notification->action = 'order';

                          $notification->save();

                      } else {
                    //  既にある加盟店ごとの注文書の一番目のIDを取得
                        $store_order_id = StoreOrder::whereStoreId($store->id)->whereOrderId($order->id)->first()->id;
                      }
                //  注文詳細を作成
                    $order_item = OrderItem::create([
                        'order_id' => $order->id,
                        'store_order_id' => $store_order_id,
                        'item_id' => $cart_item->item->id,
                        'quantity' => $cart_item->quantity,
                        'price_after_tax' => $cart_item->item->price_before_tax * $tax,
                      ]);
                // 支払方法がカードなら
                    if ($order->pay_method == 0) {
                        $store_order->order_status = 1;
                        $order_item->product_status = 1;
                    //保存
                        $store_order->save();
                        $order_item->save();
                // 注文ステータスを"入金確認"、製作ステータスを"製作待ち"に変更
                    }
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
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('msg_danger', '注文の確定に失敗しました。入力情報などに誤りはありませんか？');
        }
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
        $user = \Auth::user();
        $orders = Order::whereUserId($user->id)->get()
                  ->sortByDesc('created_at');
        // $orders = $user->orders->sortByDesc('created_at');
        return view('user.order.index', ['orders'=>$orders]);
    }

    public function show($id) {
        $order = Order::find($id);
        $store_orders = $order->store_orders;
        return view('user.order.show', ['order'=>$order, 'store_orders'=>$store_orders]);
    }
}
