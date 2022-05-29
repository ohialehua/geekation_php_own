<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\WarningMail;
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
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $store = Store::find($id);
        $items = $store->items;
        $posts = $store->store_posts;
        return view('admin.store.show',
                   [
                    'store'=>$store,
                    'items'=>$items,
                    'posts'=>$posts,
                   ]);
    }

    public function update(Request $request) {
        $store = Store::find($request->id);
    try {
        $params = $request->all();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $store->fill($params)->save();

        $name = $store->name;
        $email = $store->email;
        $admin_email = config('mail.mailers.smtp.username');
        $admin_tel = '0120-000-000';
        if ($store->is_deleted == 1) {
            Mail::send(new WelcomeMail($name, $email, $admin_email, $admin_tel));
        } elseif ($store->is_deleted == 0) {
            Mail::send(new WarningMail($name, $email, $admin_email, $admin_tel));
        }
    } catch (\Exception $e) {
        return back()->with('msg-danger', 'ステータスの変更に失敗しました');
    }
        //リダイレクト
        return back()->with('msg_secondary', "{$store->name}のステータスを変更しました");
    }
}
