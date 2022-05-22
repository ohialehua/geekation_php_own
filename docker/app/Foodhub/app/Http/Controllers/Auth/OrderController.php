<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Item;
use App\Models\Delivery;

class OrderController extends Controller
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
    public function new(){
        $user = \Auth::user();
        $deliveries = Delivery::whereUserId($user->id)->get();
        return view('user.order.new', ['deliveries'=>$deliveries]);
    }

    public function confirm(Request $request){
        return view('user.order.confirm');
    }

    public function create(Request $request){
    }

    public function complete(){
        return view('user.order.complete');
    }

    public function index(){
    }

    public function show($id) {
        $order = Order::find($id);
        return view('user.order.show', ['order'=>$order]);
    }
}
