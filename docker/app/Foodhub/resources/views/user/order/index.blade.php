<!-- ★ -->
<?php use App\Models\StoreOrder; ?>

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="col-lg-9">
      <div class="card mb-5">
        <div class="card-header">{{ __('注文履歴一覧') }}</div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <table class="table table-light">
                  <thead>
                    <td>注文日</td>
                    <td>配送先</td>
                    <td>購入店舗名</td>
                    <td>注文商品</td>
                    <td>支払金額</td>
                    <td>発送状況</td>
                    <td>注文詳細</td>
                  </thead>
                @foreach ($orders as $order)
                  <tr>
                    <td>{{date('Y年m月d日', strtotime($order->created_at))}}</td>
                    <td>
                      〒{{$order->post_address}}<br>
                        {{$order->address}}<br>
                        {{$order->name}}
                    </td>
                    <td>
                    @foreach ($order->store_orders as $store_order)
                      <a href="{{$store_order->store->id}}" class="text-dark">{{$store_order->store->name}}</a>
                    <!-- 加盟店名と加盟店での注文商品の行を合わせる -->
                        @foreach ($store_order->order_items as $order_item)
                          <br>
                        @endforeach
                    @endforeach
                    </td>
                    <td>
                    @foreach ($order->store_orders as $store_order)
                      @foreach ($store_order->order_items as $order_item)
                        {{$order_item->item->name}}<br>
                      @endforeach
                    @endforeach
                    </td>
                    <td>{{number_format($order->total_price)}}円</td>
                    <!-- ★ここで使用 -->
                  @if (StoreOrder::whereOrderId($order->id) ->whereOrderStatus(0, 1, 2, 3))
                    <td class="text-danger">
                      まだ発送されていない商品があります
                    </td>
                  @else
                    <td class="text-success">
                      全ての商品が発送されました
                    </td>
                  @endif
                    <td><a href="{{$order->id}}" class="text-dark">表示</a></td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
