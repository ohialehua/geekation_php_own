<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
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
