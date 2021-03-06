<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Relationship;


class UserController extends Controller
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

    public function index() {
        $user = \Auth::user();
        $users = User::all();
        $following_users = Relationship::where('followed_id', $user->id)->get();
        $follower_users = Relationship::where('follower_id', $user->id)->get();
        return view('user.index',
                   [
                    'users'=>$users,
                    'following_users'=>$following_users,
                    'follower_users'=>$follower_users,
                   ]);
    }

    public function show($id) {
        $user = User::find($id);
        $posts = $user->user_posts;
        $following_count = Relationship::where('followed_id', $user->id)->count();
        $follower_count = Relationship::where('follower_id', $user->id)->count();
        return view('user.show',
                   [
                    'user'=>$user,
                    'posts'=>$posts,
                    'following_count'=>$following_count,
                    'follower_count'=>$follower_count,
                   ]);
    }

    public function edit() {
        return view('user.edit', ['user' => \Auth::user() ]);
    }

    public function update(Request $request) {

    try {
        $params = $request->all();
        $user = \Auth::user();

        //不要な「_token」の削除
        unset($params['_token']);
        //保存
        $user->fill($params)->save();

        // アップロードされたファイル
        $profileImage = $request->file('profile_image');
        if ($profileImage) {
            $file_name  = $user->id . "." . $profileImage->clientExtension();
            $path = $profileImage->storeAs('public/user_profiles', $file_name);
            // profile_imageカラムにファイル名をを保存
            $user->profile_image = basename($path);
            $user->save();
        }
    } catch (\Exception $e) {
        return back()->with('msg_danger', '編集に失敗しました');
    }
        //リダイレクト
        return redirect('/home')->with('msg_secondary', '会員情報を編集しました');
    }
}
