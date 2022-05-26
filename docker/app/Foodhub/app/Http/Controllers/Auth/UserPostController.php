<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPost;

class UserPostController extends Controller
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

                $image = $request->file('post_image');
                if ($image) {
                  $file_name  = $user->id . "." . $post->id . "." . $image->clientExtension();
                  $path = $image->storeAs('public/user_post_images', $file_name);
                  $post->post_image = basename($path);
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
        $user = \Auth::user();
        $post = UserPost::find($id);
        return view('user.post.show', ['post'=>$post, 'user'=>$user]);
    }

    public function destroy($id) {
        $user = \Auth::user();
        $post = UserPost::find($id);
        if ($post->user_id == $user->id) {
            $post->delete();
            return redirect('home')->with('msg_warning', '投稿を削除しました');
        } else {
            return back()->with('msg_danger', '投稿の削除に失敗しました');
        }
    }
}
