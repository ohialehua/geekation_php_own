<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Item;

class CartItemController extends Controller
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

    public function create(Request $request)
    {
        try {
                $user = \Auth::user();
                $item = Item::find($request->item_id);
                $cart_item = new CartItem($request->all());
                $cart_item->user_id = $request->user()->id;
                if ($cart_item = CartItem::whereUserId($cart_item->user_id)->whereItemId($cart_item->item_id)->first()) {
                    $cart_item->quantity += $request->quantity;
                    $cart_item->save();
                } else {
                    $cart_item = new CartItem($request->all());
                    $cart_item->user_id = $request->user()->id;
                    $cart_item->save();
                }
                return back()->with('msg_success', "{$cart_item->item->name}を{$request->quantity}個追加しました");
            // 不要な「_token」の削除
            unset($cart_item['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg_danger', '商品の追加に失敗しました');
        }
    }

    public function update(Request $request) {
        $cart_item = CartItem::find($request->id);
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $cart_item->fill($params)->save();
    } catch (\Exception $e) {
        return back()->with('msg_danger', 'カート情報の変更に失敗しました');
    }
        //リダイレクト
        return back()->with('msg_primary', "{$cart_item->item->name}を{$request->quantity}個から{$cart_item->quantity}に変更しました");
    }

    public function destroy($id) {
        $cart_item = CartItem::find($id);
        $name = $cart_item->item->name;
        $cart_item->delete();
        return back()->with('msg_warning', "{$name}をカートから戻しました");
    }

    public function destroy_all(Request $request) {
        $cart_item = CartItem::query($request->user_id)->delete();
        return back()->with('msg_danger', 'カートの中身を全て戻しました');
    }
}
