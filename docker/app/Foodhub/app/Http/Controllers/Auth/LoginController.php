<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect('/login');
    }

    // protected function credentials(Request $request)
    // {
    //     $temporary = $request->only($this->username(), 'password');
    //     try {
    //         $user = User::where('email', $request->email)->first();
    //         if ($user->email == $request->email) {
    //             back()->with('msg_success', 'ログインしました');
    //         }
    //     } catch (\Exception $e) {
    //             back()->with('msg_danger', 'このメールアドレスのアカウントは存在しません。');
    //     }
    //     return $temporary;
    // }
}
