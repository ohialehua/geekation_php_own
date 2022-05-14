<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

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
    protected $redirectTo = '/store/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:store')->except('logout');
    }
    public function showLoginForm()
    {
        return view('store.login');  //変更
    }

    protected function guard()
    {
        return Auth::guard('store');  //変更
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::guard('store')->logout();  //変更
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/store/login');  //変更
    }
}
