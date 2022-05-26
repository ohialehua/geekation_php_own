<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPost;

class UserPostController extends Controller
{
    public function new()
    {
        return view('user.post.new');
    }

    public function create(Request $request)
    {
        $user = \Auth::user();

        try {
                $post = new UserPost($request->all());
                $post->user_id = $user->id;
                $post->save();

                $image = $request->file('post_image_id');
                if ($image) {
                  $file_name  = $user->id . "." . $post->id . "." . $image->clientExtension();
                  $path = $image->storeAs('public/user_post_images', $file_name);
                  $post->post_image_id = basename($path);
                  $post->save();
                }
            // 不要な「_token」の削除
            unset($post['_token']);
            //保存
        } catch (\Exception $e) {
            return back()->with('msg_danger', '新規投稿に失敗しました');
        }
            //リダイレクト
            return redirect('home')->with('msg_success', '新規投稿しました');
    }

    public function show($id) {
        $post = UserPost::find($id);
        return view('user.post.show', ['post'=>$post]);
    }

    public function destroy($id) {
        $post = UserPost::find($id)->delete();
        return redirect('home')->with('msg_warning', '投稿を削除しました');
    }
}
