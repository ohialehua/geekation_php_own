<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StorePost;
use App\Models\Store;

class StorePostController extends Controller
{
    public function new()
    {
        return view('store.post.new');
    }

    public function create(Request $request)
    {
        $store = \Auth::user();

        try {
                $post = new StorePost($request->all());
                $post->store_id = $store->id;
                $post->save();

                $image = $request->file('post_image_id');
                if ($image) {
                  $file_name  = $store->id . "." . $post->id . "." . $image->clientExtension();
                  $path = $image->storeAs('public/post_images', $file_name);
                  $post->post_image_id = basename($path);
                  $post->save();
                }
            // 不要な「_token」の削除
            unset($post['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg-danger', '商品登録に失敗しました');
        }
            //リダイレクト
            return redirect('store/home')->with('msg_success', '新規投稿しました');
    }

    public function show($id) {
        $post = StorePost::find($id);
        return view('store.post.show', ['post'=>$post]);
    }

    public function destroy($id) {
        $post = StorePost::find($id)->delete();
        return redirect('store/home')->with('msg_warning', '投稿を削除しました');
    }
}
