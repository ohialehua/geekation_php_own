<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Store;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest:store');
    }
    public function showRegisterForm()
    {
        return view('store.register');  //変更
    }

    public function logout(Request $request)
    {
        Auth::guard('store')->logout();  //変更
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/store/login');  //変更
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:12'],
            'name_kana' => ['required', 'string', 'max:24'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:stores'],
            'post_address' => ['required', 'string', 'max:12'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new store instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Store
     */
    protected function create(array $data)
    {
        return Store::create([
            'name' => $data['name'],
            'name_kana' => $data['name_kana'],
            'email' => $data['email'],
            'post_address' => $data['post_address'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('store'); //管理者認証のguardを指定
    }
}
