<?php

namespace App\Http\Controllers\Store;

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
        $this->middleware('auth:store');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function new()
    {
        return view('store.item.new');
    }

    public function create(Request $request)
    {
        $store = \Auth::user();
        $item = $store->item;

        try {
                $newItem = new Item($request->all());
                  $newItem->store_id = $request->user()->id;
                  $newItem->save();

                $image = $request->file('image');
                if ($image) {
                  $file_name  = $store->id . "." . $newItem->id . "." . $image->clientExtension();
                  $path = $image->storeAs('public/item_images', $file_name);
                  $newItem->image = basename($path);
                  $newItem->save();
                }
            // 不要な「_token」の削除
            unset($newItem['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg-danger', '商品登録に失敗しました');
        }
            //リダイレクト
            return redirect('store/home')->with('msg_success', '新規商品を登録しました');
    }

    public function edit($id) {
        $item = Item::find($id);
        return view('store.item.edit', ['item'=>$item]);
    }

    public function update(Request $request) {
        $item = Item::find($request->id);
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $item->fill($params)->save();
    } catch (\Exception $e) {
        return back()->with('msg-danger', '編集に失敗しました');
    }
        //リダイレクト
        return redirect('store/home')->with('msg_secondary', '商品情報を編集しました');
    }
}
