<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function unsubscribe() {
        return view('store.unsubscribe', ['store' => \Auth::user() ]);
    }

    public function withdraw(Request $request) {
        $store = \Auth::user();
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $store->fill($params)->save();

        Auth::guard('store')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
    } catch (\Exception $e) {
        return back()->with('msg_danger', '退会に失敗しました');
    }
        return redirect('store/register')->with('msg_danger', 'Foodhubを退会しました');
    }
}
