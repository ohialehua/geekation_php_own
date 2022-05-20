<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
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
        $this->middleware('auth:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->full_name && $user->full_name_kana && $user->phone_number) {
            return view('user.delivery.index');
        } else {
            return view('user.edit')->with('msg_info', '個人情報を登録してください');
        }
    }

    public function create(Request $request)
    {
        try {
                $delivery = new Delivery($request->all());
                $delivery->user_id = $request->user()->id;
                $delivery->save();
            // 不要な「_token」の削除
            unset($delivery['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg-danger', '配送先登録に失敗しました');
        }
            //リダイレクト
            return redirect('user/delivery/index')->with('msg_success', '新しい配送先を登録しました');
    }

    public function edit($id) {
        $delivery = Delivery::find($id);
        return view('user.delivery.edit', ['delivery'=>$delivery]);
    }

    public function update(Request $request) {
        $delivery = Delivery::find($request->id);
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $delivery->fill($params)->save();
    } catch (\Exception $e) {
        return back()->with('msg-danger', '編集に失敗しました');
    }
        //リダイレクト
        return redirect('user/delivery/index')->with('msg_secondary', '配送先情報を編集しました');
    }

    public function destroy($id) {
        $delivery = Delivery::find($id)->delete();
        return redirect('user/delivery/index')->with('msg_warning', '配送先を削除しました');    }
}
