<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

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
                  $newItem->store_id = \Auth::user()->id;
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

    public function show()
    {
        $store = \Auth::user();
        return view('store.home', ['store'=>$store]);
    }

    public function edit() {
        return view('store.edit', ['store' => \Auth::user() ]);
    }

    public function update(Request $request) {

    try {
        $params = $request->all();
        $store = \Auth::user();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $store->fill($params)->save();

        // アップロードされたファイル
        $profileImage = $request->file('profile_image');
        if ($profileImage) {
            $file_name  = $store->id . "." . $profileImage->clientExtension();
            $path = $profileImage->storeAs('public/store_profiles', $file_name);
            // profile_imageカラムにファイル名をを保存
            $store->profile_image = basename($path);
            $store->save();
        }
    } catch (\Exception $e) {
        return back()->with('msg-danger', '編集に失敗しました');
    }
        //リダイレクト
        return redirect('store/home')->with('msg_secondary', '加盟店情報を編集しました');
    }
}
